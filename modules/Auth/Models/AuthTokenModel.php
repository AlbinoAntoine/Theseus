<?php

namespace Modules\Auth\Models;

use CodeIgniter\Model;

class AuthTokenModel extends Model
{
    protected $table      = 'Auth_tokens';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType    = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['Id_User', 'Crypted_Code', 'Expires'];

//    protected $useTimestamps = true;
//    protected $createdField  = 'Date_Creation';
//    protected $updatedField  = 'Date_Updated';
//    protected $deletedField  = 'deleted_at';

//    protected $validationRules    = [];
//    protected $validationMessages = [];
//    protected $skipValidation     = false;
//Update
}