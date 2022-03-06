<?php

namespace Modules\Auth\Validation;

use Modules\Auth\Libraries\AdminAuthLib;
use Modules\Auth\Libraries\AuthLib;
use Modules\Auth\Models\UsersModel;


class AuthRules
{
    public function validateUser(string $str, string $fields, array $data, string &$error = null)
    {
        $model = new UsersModel();
        $AuthLib = new AuthLib();
        $db = db_connect();
        $user = $model->select('*, AES_DECRYPT(Password,'.$db->escape(CLEF_SEC).') as Password', false)->where('email', $data['email'])->first();

        if (!$user) {
            $error = 'Failed to identify. <br> Check your email and password.';
            return false;
        } elseif ($data['password'] != $user->Password) {
            $error = 'Failed to identify.<br> Check your email and password.';
            $AuthLib->loginlogFail($data['email']);
            return false;
        } else {
            return true;
        }
    }

    public function checkUniqueEmail(string $str, string $fields, array $data, string &$error = null)
    {
        $model = new UsersModel();
        $user = $model->where('Email', $data['email'])->find();

        if (!empty($user)) {
            $error = 'Email already used';
            return false;
        } else {
            return true;
        }
    }
}