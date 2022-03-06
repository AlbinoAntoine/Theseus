<?php

namespace Modules\Auth\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Model;
use Modules\Auth\Libraries\AuthLib;
use Modules\Auth\Models\ConnexionsModel;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        $this->Auth = new AuthLib;
        session_start();
        if (empty($_SESSION['Session_User'])) {
            if (!empty($_COOKIE['remember'])){
                $AuthLib = new AuthLib();
                if($AuthLib->checkCookie()==false){
                    return redirect()->to(site_url('login'));
                }
            }else{
                return redirect()->to(site_url('login'));
            }
        }
        return true;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}