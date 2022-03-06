<?php

namespace Modules\Auth\Controllers;
use App\Controllers\BaseController;
use Modules\Auth\Libraries\AuthLib;
use Modules\Auth\Models\UsersModel;
use Modules\Commun\Config\ConfigEmail;


class Auth extends BaseController
{

    public function __construct()
    {
        $this->AuthLib = new AuthLib;
    }



    public function register()
    {
        helper('form');
        $validation = \Config\Services::validation();

        $request = \Config\Services::request();
        //$Client_config = new Users();

        $rules = empty($_POST) ? [] : [
            'nom' => [
                'label' => 'Nom',
                'rules' => 'required|trim|max_length[30]'
            ],
            'prenom' => [
                'label' => 'Prenom',
                'rules' => 'required|trim|max_length[30]'
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|trim|max_length[50]|checkUniqueEmail[email]'
            ],
            'password' => [
                'label' => 'Mot de passe',
                'rules' => 'required|trim|max_length[50]'
            ],
            'password2' => [
                'label' => 'Mot de passe',
                'rules' => 'required|trim|max_length[50]'
            ],
        ];

        $data = [
            'title' => 'Register | Theseus',
        ];

        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('\Modules\Auth\Views\register', $data);
        } else {

            $UserModel = new UsersModel();

            while (TRUE) {
                $unique_id = random_string('crypto', 10);
                if (empty($UserModel->where('Unique_Key', $unique_id)->find())) {
                    break;
                }
            }

            $db = db_connect();

            $Nom = $request->getPost('nom');
            $Prenom = $request->getPost('prenom');
            $Email = $request->getPost('email');
            $Password = 'AES_ENCRYPT('.$db->escape($request->getPost('password')).','.$db->escape(CLEF_SEC).')';
            $Unique_Key = $unique_id;

            $sql = "INSERT INTO Users (Nom, Prenom, Email, Password, Unique_Key) VALUES(" . $db->escape($Nom).', '. $db->escape($Prenom).', '. $db->escape($Email).', '.$Password.', '.$db->escape($Unique_Key).")";
            $creation = $db->query($sql);

//            $users_data = [
//                'Nom' => $request->getPost('nom'),
//                'Prenom' => $request->getPost('prenom'),
//                'Email' => $request->getPost('email'),
//                'Password' => 'AES_DECRYPT('.$request->getPost('password').','.CLEF_SEC.') as Password',
//                'Unique_Key' => $unique_id,
//            ];
            //$creation = $UserModel->insert($users_data,true);

            if ($creation!=false) {

                $secret_code = hash('sha256', $creation.'|'.$unique_id);
                $users_data['secret_code']=$secret_code;

                //$message = view('\Modules\Auth\Views\email\verifEmail', $users_data);

                //TODO : Tester envoie mail et faire page vérification email et supprimer email
//                $ConfigEmail = new ConfigEmail();
//                $email = \Config\Services::email();
//                $result = $email
//                    ->setFrom($ConfigEmail->compte_email['from'], $ConfigEmail->compte_email['fromname'])
//                    ->setTo($request->getPost('email'))
//                    ->setSubject('Vérifier son Email')
//                    ->setMessage($message)
//                    ->send();
//
//                if ($result) {
//                    session()->setFlashdata('type', 'succes');
//                    session()->setFlashdata('mess', 'Un email vous a été envoyé pour vérifier votre adresse Email');
//
                    $this->AuthLib->LoginUser($request->getPost('email'));
                    return redirect()->to(site_url());
//                } else {
//                    session()->setFlashdata('type', 'error');
//                    session()->setFlashdata('mess', 'Erreur lors de la création du compte. Veuillez recommencer.'); //TODO : Quoi faire si l'email n'a pas été envoyé
//                }
            } else {
                session()->setFlashdata('mess', 'Erreur lors de la création du compte. Veuillez recommencer.');
            }

            return view('\Modules\Auth\Views\register', $data);
        }
    }

    /**
     * @param int $length
     * @return string
     */
    private function get_unique_id(int $length = 12): string
    {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $random_string = "";

        for ($p = 0; $p < $length; $p++)
        {
            $random_string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $random_string;
    }

    public function login()
    {
        helper('form');

        $rules = empty($_POST) ? [] : [
            'email' => [
                'label' => 'E-mail',
                'rules' => 'trim|max_length[50]|required'
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'trim|required|validateUser[email,password]'
            ],
        ];

        $data = [
            'title'=> 'Login | Organize-me',
        ];

        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('\Modules\Auth\Views\login', $data);
        } else {
            // GET EMAIL & REMEMBER ME FROM POST
            $email = $_POST['email'];

            // PASS TO LIBRARY
            $this->AuthLib->Loginuser($email);

            if (!empty($_POST['rememberme'])){
                // IF REMEMBER ME FUNCTION IS SET TO TRUE IN CONFIG
                    $this->AuthLib->rememberMe($_SESSION['Session_User']['Id_User']);
            }
        }
        return redirect()->to(site_url());
    }
    private function make_passwd()
    {
        if (func_num_args() == 1)
        {
            $nb = func_get_arg(0);
        }
        else
        {
            $nb = 8;
        }
        // on utilise certains chiffres : 1 = i, 5 = S, 6=b, 3=E, 9=G, 0=O
        $lettre = array();
        $lettre[0] = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'o', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'D', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '9', '0', '6', '5', '1', '3');
        $lettre[1] = array('a', 'e', 'i', 'o', 'u', 'y', 'A', 'E', 'I', 'O', 'U', 'Y', '1', '3', '0');
        $lettre[-1] = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'z', 'B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Z', '5', '6', '9');

        $retour = "";
        $prec = 1;
        $precprec = - 1;
        srand((double)microtime() * 20001107);

        while (strlen($retour) < $nb)
        {
            // pour genere la suite de lettre, on dit : si les deux lettres sonts
            // des consonnes (resp. des voyelles) on affiche des voyelles (resp, des consonnes).
            // si les lettres sont de type differents, on affiche une lettre de l'alphabet
            $type = ($precprec + $prec) / 2;
            $r = $lettre[$type][array_rand($lettre[$type], 1)];
            $retour .= $r;
            $precprec = $prec;
            $prec = in_array($r, $lettre[-1]) - in_array($r, $lettre[1]);
        }

        return strtolower($retour);
    }
    public function forgotten_password()
    {
        helper('form');
        //TODO : A Faire, non fonctionnel
        $rules = empty($_POST) ? [] : [
            'name' => [
                'label' => 'Nom et prénom',
                'rules' => 'trim|max_length[200]|required'
            ],
            'email' => [
                'label' => 'E-mail',
                'rules' => 'trim|max_length[100]|valid_email|required'
            ],
        ];

        $data = [
            'title' => 'Mot de passe oublié | Colaco',
        ];

        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('\Modules\Auth\Views\forgotten_password', $data);
        } else {
            $email = \Config\Services::email();

            $email->setFrom('contact@colaco.fr', 'Colaco Site');
            $email->setTo('laurent@alphastudio.fr');
            $email->setReplyTo($_POST['mail']);
            $email->setBCC('contact@alphastudio.fr');

            $email->setSubject('Mot de passe oublié colaco.fr : ' . $_POST['codeclient']);

            $email_data = [
                'name' => $_POST['name'],
                'mail' => mailto($_POST['mail']),
                'codeclient' => $_POST['codeclient'],
                'organisation' => $_POST['organisation'],
                'phone' => $_POST['phone'],
            ];

            $email->setMessage(view('\Modules\Auth\Views\email\forgotten_password', $email_data));

            $sent = $email->send();

            if (!$sent) {
                //$email->printDebugger();
                $data['validation'] = $this->validator;
                return view('\Modules\Auth\Views\forgotten_password', $data);
            } else {
                return view('\Modules\Auth\Views\forgotten_password_feedback', $data);
            }
        }
    }

    public function logout()
    {
        $this->AuthLib->logout();
        return redirect()->to(site_url()); // TODO feedback deconnection
    }

}