<?php

namespace Modules\Auth\Libraries;

//use Modules\Auth\Models\AuthTokenModel;
use Modules\Auth\Models\AdminAuthTokenModel;
use Modules\Auth\Models\AuthLogAdminModel;
use Modules\Coladm\Models\AdminModel;
use Modules\Auth\Config\Auth;
use Config\App;
use \Config\Services;

class AdminAuthLib
{


    public function __construct()
    {
        $this->AdminAuthTokenModel = new AdminAuthTokenModel();
        $this->AuthLogAdminModel = new AuthLogAdminModel();
        $this->AdminModel = new AdminModel();
        $this->config = new Auth;
        $this->AppConfig = new App;
        $this->request = Services::request();
        helper('text');
    }
    public function checkCookieAdmin()
    {
        helper('cookie');

        // IS THERE A COOKIE SET?
        $remember = get_cookie('rememberadmin');

        // NO COOKIE FOUND
        if (empty($remember)) {
            return;
        }

        // GET OUR SELECTOR|VALIDATOR VALUE
        [$selector, $validator] = explode(':', $remember);
        $validator = hash('sha256', $validator);

        $token = $this->AdminAuthTokenModel->where('selector', $selector)->first();

        // NO ENTRY FOUND
        if (empty($token)) {
            return false;
        }

        // HASH DOESNT MATCH
        if (!hash_equals($token->hashedvalidator, $validator)) {
            return false;
        }

        // WE FOUND A MATCH SO GET USER ID
        $user = $this->AdminModel->find($token->Id_User);

        // NO USER FOUND
        if (empty($user)) {
            return false;
        }

        // USER IS DEACTIVATED
        if (!$user->active) {
            $this->AdminAuthTokenModel->where('Id_User', $token->Id_User)->delete();
            return false;
        }

        // SET USER SESSION
        $this->setAdminSession($user);

        $userID = $token->Id_User;

        $this->rememberMeResetAdmin($userID, $selector);

        return;
    }


    public function rememberMeResetAdmin($userID, $selector)
    {
        // DB QUERY
        $existingToken = $this->AdminAuthTokenModel->where('selector', $selector)->first();

        if (empty($existingToken)) {
            return $this->rememberMeAdmin($userID);
        }

        $validator = random_string('crypto', 20);
        $expires = time() + 60 * 60 * 24 * $this->config->rememberMeExpire;

        // SET OUR TOKEN
        $token = $selector . ':' . $validator;

        if ($this->config->rememberMeRenew) {
            // SET DATA ARRAY
            $data = [
                'hashedvalidator' => hash('sha256', $validator),
                'expires' => date('Y-m-d H:i:s', $expires),
            ];
        } else {
            // SET DATA ARRAY
            $data = [
                'hashedvalidator' => hash('sha256', $validator),
            ];
        }

        $this->AdminAuthTokenModel->update($existingToken->id, $data);

        // SET COOKIE
        setcookie(
            "rememberadmin",
            $token,
            $expires,
            $this->AppConfig->cookiePath,
            $this->AppConfig->cookieDomain,
            $this->AppConfig->cookieSecure,
            $this->AppConfig->cookieHTTPOnly
        );
        return true;
    }


    public function setAdminSession($user): bool
    {
        $data['Session_Admin'] = [
            'id' => $user->id,
            'email' => $user->email,
            'isAdmin' => $user->role_id,
            'isLoggedInAdmin' => true,
            'ipaddress' => $this->request->getIPAddress(),
        ];

        session()->set($data);

        $Id_Connexion = $this->loginlogAdmin();

        $_SESSION['Session_Admin']['Id_Connexion'] = $Id_Connexion;

        // SET COOKIE
        setcookie(
            "coladmSession",
            $Id_Connexion,
            0,
            $this->AppConfig->cookiePath,
            $this->AppConfig->cookieDomain,
            $this->AppConfig->cookieSecure,
            $this->AppConfig->cookieHTTPOnly
        );

        return true;
    }


    public function loginlogAdmin()
    {
        // LOG THE LOGIN IN DB
        if (!empty($_SESSION['Session_Admin']['isLoggedInAdmin'])) {

            $logdata = [
                'Id_user' => $_SESSION['Session_Admin']['id'],
                'ip_address' => $this->request->getIPAddress(),
                'Date_Connexion' => date('Y-m-d H:i:s'),
                'successful' => '1',
            ];

            return $this->AuthLogAdminModel->insert($logdata);
        }
        return ;
    }


    public function loginlogFailAdmin($email)
    {
        // FIND USER
        $user = $this->AdminModel->where('email', $email)->first();

        if (!empty($user)) {

            // BUILD DATA TO ADD TO auth_logins TABLE
            $logdata = [
                'Id_user' => $user->id,
                'ip_address' => $this->request->getIPAddress(),
                'Date_Connexion' => date('Y-m-d H:i:s'),
                'successful' => '0',
            ];

            // SAVE LOG DATA TO DB
            $this->AuthLogAdminModel->insert($logdata);
        }
    }


    public function LoginAdmin($mailAdmin, $rememberMe)
    {
        // GET USER DETAILS FROM DB
        $user = $this->AdminModel->where('email', $mailAdmin)->first();

        // SET USER ID AS A VARIABLE
        $userID = $user->id;

        // IF REMEMBER ME FUNCTION IS SET TO TRUE IN CONFIG
        if ($this->config->rememberMe && $rememberMe == '1') {
            $this->rememberMeAdmin($userID);
            session()->set('remembermeadmin', $rememberMe);
        }

        //SET USER SESSION
        $this->setAdminSession($user);
    }

    public function rememberMeAdmin($userID)
    {
        // SET UP OUR SELECTOR, VALIDATOR AND EXPIRY
        //
        // The selector acts as unique id so we dont have to save a user id in our cookie
        // the validator is saved in plain text in the cookie but hashed in the db
        // if a selector (id) is found in the auth_tokens table we then match the validators

        $selector = random_string('crypto', 12);
        $validator = random_string('crypto', 20);
        $expires = time() + 60 * 60 * 24 * $this->config->rememberMeExpire;

        // SET OUR TOKEN
        $token = $selector . ':' . $validator;

        // SET DATA ARRAY
        $data = [
            'Id_User' => $userID,
            'selector' => $selector,
            'hashedvalidator' => hash('sha256', $validator),
            'expires' => date('Y-m-d H:i:s', $expires),
        ];

        // CHECK IF A USER ID ALREADY HAS A TOKEN SET
        //
        // We dont really want to have multiple tokens and selectors for the
        // same user id. there is no need as the validator gets updated on each login
        // so check if there is a token already and overwrite if there is.
        // should keep DB maintenance down a bit and remove the need to do sporadic purges.

        $existingToken = $this->AdminAuthTokenModel->where('Id_User', $userID)->first();

        // IF NOT INSERT
        if (empty($existingToken)) {
            $this->AdminAuthTokenModel->insert($data);
        }
        // IF HAS UPDATE
        else {
            $this->AdminAuthTokenModel->update($existingToken->id, $data);
        }

        // set_Cookie
        setcookie(
            "rememberadmin",
            $token,
            $expires,
            $this->AppConfig->cookiePath,
            $this->AppConfig->cookieDomain,
            $this->AppConfig->cookieSecure,
            $this->AppConfig->cookieHTTPOnly
        );
    }


    public function logout()
    {
        // REMOVE REMEMBER ME TOKEN FROM DB
        $this->AdminAuthTokenModel->where('Id_User', session()->get('Id_User'))->delete();

        //DESTROY SESSION
        unset($_SESSION['Session_Admin']);
        setcookie("coladmSession", "", time() - 3600,
            $this->AppConfig->cookiePath,
            $this->AppConfig->cookieDomain,
            $this->AppConfig->cookieSecure,
            $this->AppConfig->cookieHTTPOnly
        );
        setcookie("Test", "123","",$this->AppConfig->cookiePath,
            $this->AppConfig->cookieDomain,
            $this->AppConfig->cookieSecure,
            $this->AppConfig->cookieHTTPOnly
        );

    }

}