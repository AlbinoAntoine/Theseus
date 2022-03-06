<?php

namespace Modules\Profile\Controllers;

use App\Controllers\BaseController;
use Modules\Auth\Models\UsersModel;
use Modules\Profile\Libraries\ProfileLib;
use Modules\Projets\Models\MemberModel;
use Modules\Projets\Models\ProjectModel;
use Modules\Projets\Models\StepModel;
use Modules\Projets\Models\TaskModel;

class Profile extends BaseController
{
    public function __construct()
    {
        $this -> ProfileLib = new ProfileLib();
    }

    public function profile($id_user)
    {
        $user = new UsersModel();
        $profile = $user -> get_user($id_user);
        $myProfile = $profile->Id_User == $_SESSION["Session_User"]["Id_User"];
        $data =[
            'title' => 'Profile | '.$profile->Nom.' '.$profile->Prenom,
            'profile' => $profile,
            'myProfile' => $myProfile
        ];

        return view('Modules\Profile\Views\profile', $data);
    }
    public function updatePP($id_user){
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $rules = empty($_FILES) ? [] : [
            'pp_user' => [
                'label' => 'Your profile picture',
                'rules' => 'uploaded[pp_user]|max_size[pp_user,1600]|mime_in[pp_user,image/jpeg,image/jpg,image/png]'
            ],
        ];

        $data = [
            'title' => 'Update Profile Picture | Theseus',
        ];
        if (!$this->validate($rules)) {
            unset($_FILES);
            $data['validation'] = $this->validator;
            return view('\Modules\Profile\Views\update_pp', $data);

        } else {
            $file = $this->request->getFile('pp_user');

            if (! $file->isValid()) {
                throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
            }
            $mime = $file->getClientExtension();
            $fileName = 'pp_'.$_SESSION['Session_User']['Id_User'];

            if ($mime == 'png'){
                $fileName .= '.png';
            }elseif($mime == 'jpeg' || $mime == 'jpg'){
                $fileName .= '.jpg';
            }

            if (! $file->hasMoved()) {
                $path = $file->move(PP_DIR, $fileName, true);
                $this -> ProfileLib -> resize_image(PP_DIR.$fileName);
            }
            return redirect()->to(site_url('profile/'.$id_user));
        }
    }
}
