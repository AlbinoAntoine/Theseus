<?php

namespace Modules\Home\Controllers;

use App\Controllers\BaseController;
use Modules\Projets\Models\ProjectModel;

class HomePage extends BaseController
{
    public function __construct()
    {
        $this->ProjectModel = new ProjectModel();
    }

    public function index()
    {
        if (!empty($_SESSION['Session_User'])){
            $listProjets = $this->ProjectModel->get_all($_SESSION['Session_User']['Id_User']);
            $memberProjets = $this -> ProjectModel -> get_MemberProject($_SESSION['Session_User']['Id_User']);
            $data=[
                'memberProjets'=>$memberProjets,
                'listProjets' => $listProjets
            ];
            return view('Modules\Home\Views\privateHome', $data);
        }else{
            $data=[
                'page_name'=>'HomePublic',
            ];
            return view('Modules\Home\Views\publicHome', $data);
        }
    }
    public function contribute()
    {

        return view('Modules\Home\Views\contribute');
    }
}
