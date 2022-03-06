<?php

namespace Modules\Auth\Models;

use CodeIgniter\Model;

class ConnexionsModel extends Model
{
    protected $table      = 'Connexions';
    protected $primaryKey = 'Id_Connexion';

    protected $useAutoIncrement = true;

    protected $returnType    = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['Id_User', 'Ip', 'successful'];

    protected $useTimestamps = true;
    protected $createdField  = 'Date_Connexion';
    protected $updatedField  = '';
//    protected $deletedField  = 'deleted_at';

//    protected $validationRules    = [];
//    protected $validationMessages = [];
//    protected $skipValidation     = false;
}