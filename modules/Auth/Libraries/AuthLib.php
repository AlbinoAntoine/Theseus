<?php

namespace Modules\Auth\Libraries;

use Config\Database;
use Exception;
use Modules\Auth\Models\AuthTokenModel;
use Modules\Auth\Models\ConnexionsModel;
use Modules\Auth\Config\Auth;
use Config\App;
use \Config\Services;
use Modules\Auth\Models\UsersModel;

class AuthLib
{
    //private AuthTokenModel $AuthTokenModel;
//    private ConnexionsModel $ConnexionsModel;
//    private UsersModel $UsersModel;
//    private Auth $config;
//    private App $AppConfig;
//    private $request;

    /**
     * @var \CodeIgniter\Session\Session|mixed|null
     */

    public function __construct()
    {
        $this->AuthTokenModel = new AuthTokenModel();
        $this->ConnexionsModel = new ConnexionsModel();
        $this->config = new Auth;
        $this->AppConfig = new App;
        $this->request = Services::request();
        $this->UserModel = new UsersModel();
        helper('text');
    }

    public function checkCookie(): bool
    {

        $remember = $_COOKIE['remember'];

        // GET OUR SELECTOR|VALIDATOR VALUE
        [$idUser, $code_cookie] = explode('|', $remember);
        $user = $this->UserModel -> find($idUser);
        if (empty($user)){
            return false;
        }
        $token = $this->AuthTokenModel
            ->where('Id_User', $idUser)
            ->where('Crypted_Code',"AES_ENCRYPT('".$code_cookie."','".$user->Unique_Key."')", false)
            ->first();

        // NO ENTRY FOUND
        if (empty($token)) {
            return false;
        }

        //SET USER SESSION
        $_SESSION['Session_User'] = [
            'Id_User' => $user->Id_User,
            'Nom' => $user->Nom,
            'Prenom' => $user->Prenom,
        ];

        $Id_Connexion = $this->loginlog();
        $_SESSION['Session_User']['Id_Connexion'] = (int)$Id_Connexion;
        return true;
    }

    public function LoginUser($email)
    {
        // GET USER DETAILS FROM DB
        $user = $this->UserModel->where('Email', $email)->first();

        //SET USER SESSION
        $_SESSION['Session_User'] = [
            'Id_User' => $user->Id_User,
            'Nom' => $user->Nom,
            'Prenom' => $user->Prenom,
        ];

        $Id_Connexion = $this->loginlog();
        $_SESSION['Session_User']['Id_Connexion'] = (int)$Id_Connexion;
    }

    public function loginlog()
    {
        // LOG THE LOGIN IN DB
        if (!empty($_SESSION['Session_User'])) {
            $logdata = [
                'Id_User' => $_SESSION['Session_User']['Id_User'],
                'Ip' => $this->request->getIPAddress(),
                'Successful' => '1',
            ];
            return $this->ConnexionsModel->insert($logdata);
        }
        return false;
    }

    public function loginlogFail($email)
    {
        // FIND USER 
        $user = $this->UserModel->where('email', $email)->first();

        if (!empty($user)) {

            // BUILD DATA TO ADD TO auth_logins TABLE
            $logdata = [
                'Id_User' => $user->Id_User,
                'Ip' => $this->request->getIPAddress(),
                'Successful' => '0',
            ];

            // SAVE LOG DATA TO DB
            $this->ConnexionsModel->insert($logdata);
        }
    }


    public function rememberMe($userID)
    {

        $Unique_Key = $this->UserModel->select('Unique_Key')->find($userID)->Unique_Key;
        $code_cookie = random_string('crypto', 20);
        $expires = time() + 60 * 60 * 24 * $this->config->rememberMeExpire;
        $token = $userID.'|'.$code_cookie;
        $Crypted_Code = "AES_ENCRYPT('".$code_cookie."','".$Unique_Key."')";
        // SET DATA ARRAY
        $db = db_connect();
        $sql = "INSERT INTO Auth_tokens (Id_User, Crypted_Code, Expires) VALUES(" . $userID.', '. $Crypted_Code.', '. $db->escape(date('Y-m-d H:i:s', $expires)).")";
        $db->query($sql);
        // set_Cookie
        setcookie(
            "remember",
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
        // COOKIE FOUND
        if (!empty($_COOKIE['remember'])) {
            [$idUser, $code_cookie] = explode('|', $_COOKIE['remember']);
            // REMOVE REMEMBER ME TOKEN FROM DB
            $user = $this->UserModel->find($_SESSION['Session_User']['Id_User']);
            $db = db_connect();

            $this->AuthTokenModel
                ->where('Id_User', $_SESSION['Session_User']['Id_User'])
                ->where('Crypted_Code',"AES_ENCRYPT('".$code_cookie."','".$user->Unique_Key."')", false)
                ->delete();
        }
        //DESTROY SESSION
        unset($_SESSION['Session_User']);
        setcookie('remember','', time() - 3600);
    }

}