<?php

namespace Modules\Auth\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table      = 'Users';
    protected $primaryKey = 'Id_User';

    protected $useAutoIncrement = true;

    protected $returnType    = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['Id_User', 'Nom', 'Prenom', 'Email', 'Password', 'Verif_Mail', 'Unique_Key'];

    protected $useTimestamps = true;
    protected $createdField  = 'Date_Inscription';
    protected $updatedField  = 'Date_Update';
//    protected $deletedField  = 'deleted_at';

//    protected $validationRules    = [];
//    protected $validationMessages = [];
//    protected $skipValidation     = false;

    function get_user($user_id){
        return $this -> find($user_id);
    }

    function findUser($research,$project){
        return $this
            -> select('*, Users.Id_User')
            -> like('Nom', $research)
            -> orLike('Prenom', $research)
            -> join('Members', 'Users.Id_User = Members.Id_User AND  Members.Id_Projet ='.$project,'LEFT')
            -> orderBy('Nom')
            -> find();
    }
}