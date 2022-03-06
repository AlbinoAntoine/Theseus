<?php

namespace Modules\Auth\Controllers;
use App\Controllers\BaseController;
use DateTime;
use Modules\Auth\Config\Auth;
use Modules\Auth\Libraries\AdminAuthLib;
use Modules\Coladm\Config\Coladm;
use Modules\Coladm\Models\AdminModel;


class AdminAuth extends BaseController
{

    private AdminAuthLib $AdminAuth;

    public function __construct()
    {
        $this->AdminAuth = new AdminAuthLib;
    }

    public function login()
    {
        helper('form');


        $rules = empty($_POST) ? [] : [
            'mailadmin' => [
                'label' => 'Mail administrateur',
                'rules' => 'trim|max_length[50]|required'
            ],
            'password' => [
                'label' => 'Mot de passe',
                'rules' => 'trim|required|validateAdmin[mailadmin,password]'
            ],
        ];

        $data = [
            'title' => 'Connexion Admin | Colaco',
        ];

        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('\Modules\Auth\Views\admin\login', $data);
        } else {
            // GET EMAIL & REMEMBER ME FROM POST
            $mailAdmin = $this->request->getVar('mailadmin');
            $rememberMe = $this->request->getVar('rememberme');

            // PASS TO LIBRARY
            $this->AdminAuth->LoginAdmin($mailAdmin, $rememberMe);

            if (isset($_SESSION['fromadmin'])) {
                $from = $_SESSION['fromadmin'];
                unset($_SESSION['fromadmin']);
                return redirect()->to($from); // TODO feedback
            }
            else {
                return redirect()->to('/coladm'); // TODO feedback
            }

        }
    }

    public function forgotten_password()
    {
        helper('form');

        $rules = empty($_POST) ? [] : [
            'email' => [
                'label' => 'Email',
                'rules' => 'trim|max_length[100]|validateAdminExists|valid_email|required'
            ],
        ];

        $data = [
            'title' => 'Mot de passe administrateur oublié  | Colaco',
        ];

        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('\Modules\Auth\Views\admin\forgotten_password', $data);
        } else {
            $email = \Config\Services::email();

            $email->setFrom('contact@colaco.fr', 'Colaco Site');
            $email->setTo($_POST['email']);
//          $email->setReplyTo($_POST['email']);
//          $email->setBCC('contact@alphastudio.fr');

            $email->setSubject('Mot de passe oublié compte administrateur colaco.fr : ' . $_POST['email']);


            //GENERATE TOKEN AND LINK
            $token=random_string('alpha',20);

            $model = new AdminModel();
            $user = $model   ->select('id')
                                ->where('email', $_POST['email'])
                                ->first();


            $model  ->where('email', $_POST['email'])
                    ->set(['reset_hash' => $token,'time_reset' => date('Y-m-d H:i:s')])
                    ->update();

            $linkreset= site_url()."/connexion/admin/reinitialisation-mot-de-passe/".$user->id.'/'.$token;

            $email_data = [
                'email' => $_POST['email'],
                'link' => $linkreset,
            ];


            $ConfigEmail = new Coladm();

            $email->setFrom($ConfigEmail->reset_password_email['from'], $ConfigEmail->reset_password_email['fromname']);
            $email->setTo($_POST['email']);
            $email->setBCC($ConfigEmail->reset_password_email['bcc']);
            $email->setSubject($ConfigEmail->reset_password_email['subject']);

            $email->setMessage(view('\Modules\Auth\Views\admin\email\forgotten_password', $email_data));

            $sent = $email->send();

            if (!$sent) {
                //$email->printDebugger();
                $data['validation'] = $this->validator;
                return view('\Modules\Auth\Views\admin\forgotten_password', $data);
            } else {
                return view('\Modules\Auth\Views\admin\forgotten_password_feedback', $data);
            }
        }
    }
    public function reset_password($user_id,$token)
    {
        //SELECT USER RESET INFORMATION IN DATABASE


        $model = new AdminModel();
        $user = $model   ->select('reset_hash, time_reset')
            ->where('id', $user_id)
            ->first();

        //TEST IF THE TOKEN HAS NOT EXPIRED
        $now = new DateTime('now');
        $dateToken = new DateTime($user->time_reset);
        $interval=date_diff($dateToken,$now);

        if($token == $user->reset_hash && $interval->format( '%R%H') < 2 ) {
            helper('form');

            $rules = empty($_POST) ? [] : [
                'new_password' => [
                    'label' => 'Nouveau mot de passe',
                    'rules' => 'trim|required|regex_match[^(?=.*[A-Z])(?=.*[!@#$&*-])(?=.*[0-9]).{8,}$]'
                ],
                'confirm_password' => [
                    'label' => 'Confimez le mot de passe',
                    'rules' => 'trim|required|matches[new_password]'
                ],
            ];

            $data = [
                'title' => 'Réinitialisation  Admin | Colaco',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
                return view('\Modules\Auth\Views\admin\reset_password', $data);
            } else {
                $password=$_POST['new_password'];
                $model->config = new Auth;
                $key=$model->config->keyAesHash;

                $model  ->set('password_hash' ,"AES_ENCRYPT('$password','$key')",FALSE)
                        ->set('reset_hash',NULL)
                        ->where('id',$user_id)
                        ->update();

                return view('\Modules\Auth\Views\admin\reset_password_feedback');
            }
        }
    }

    public function logout()
    {
        $this->AdminAuth->logout();

        return redirect()->to(base_url().'/admin/deconnexion.php');


    }

}