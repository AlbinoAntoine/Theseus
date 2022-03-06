<?php

namespace Modules\Auth\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Modules\Auth\Libraries\AuthLib;
use Modules\Auth\Models\AuthLogAdminModel;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $this->session = \Config\Services::session();

        $this->Auth = new AuthLib;
        $this->Auth->checkCookie();

        if (!session()->get('Session_Admin')) {
            $_SESSION['fromadmin'] = current_url();
            return redirect()->to('/connexion/admin');
        }
          else {
            $AuthLogAdminModel = new AuthLogAdminModel();
            $AuthLogAdminModel->update($_SESSION['Session_Admin']['id'] , ['Date_Update' => date('Y-m-d H:i:s')]);
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}