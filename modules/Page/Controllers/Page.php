<?php

namespace Modules\Page\Controllers;

use App\Controllers\BaseController;

class Page extends BaseController
{
    public function __construct()
    {

    }

    public function Settings(){
        if (!empty($_POST['darkmode'])){
            $_SESSION['Session_User']['Dark_Mode'] = $_POST['darkmode'] ?? 0;
        }elseif(!empty($_SESSION['Session_User']['Dark_Mode'])){
            unset($_SESSION['Session_User']['Dark_Mode']);
        }
        return view('Modules\Page\Views\settings');
    }
    public function legalStatement(){

        return view('Modules\Page\Views\legal_statement');
    }
    public function update(){

        return view('Modules\Page\Views\update');
    }
}
