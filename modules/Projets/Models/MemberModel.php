<?php

namespace Modules\Projets\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table      = 'Members';
    protected $primaryKey = 'Id_Member';

    protected $useAutoIncrement = true;

    protected $returnType    = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['Id_Member', 'Id_User', 'Id_Projet', 'Salaire','Role'];

    protected $useTimestamps = true;
    protected $createdField  = 'Date_Creation';
    protected $updatedField  = '';
//    protected $deletedField  = 'deleted_at';

//    protected $validationRules    = [];
//    protected $validationMessages = [];
//    protected $skipValidation     = false;

    public function get_member($id_project){
        $list_membres = $this -> where('Id_Projet', $id_project)
            -> join('Users', 'Members.Id_User = Users.Id_User' )
            -> orderBy('Date_Creation','DESC') -> find();
        $tableMember=[];
        foreach ($list_membres as $membre){
            $tableMember[$membre->Id_User] = $membre->Prenom . ' '.$membre->Nom ;
        }
        return $tableMember;
    }
    public function get_memberInfo($id_project){
        $list_membres = $this
            -> select('*, Members.Id_User, SUM(Tasks.Duration)/10000 as totalTime')
            -> where('Members.Id_Projet', $id_project)
            -> join('Users', 'Members.Id_User = Users.Id_User' )
            -> join('Projets', 'Members.Id_Projet = Projets.Id_Projet', 'LEFT')
            -> join('Tasks', 'Projets.Id_Projet = Tasks.Id_Projet AND Members.Id_User = Tasks.Id_User', 'LEFT')
            -> groupBy('Members.Id_Member')
            -> orderBy('Members.Date_Creation','ASC')
            -> find();

        $tableMember=[];
        foreach ($list_membres as $membre){
            $tableMember[$membre->Id_Member] = [
                'id_user'=> $membre->Id_User,
                'member' => $membre->Prenom . ' '.$membre->Nom,
                'totalTime'=> $membre->totalTime,
                'salaire'=> $membre->Salaire,
                'role'=> $membre->Role,
            ];
        }
        return $tableMember;
    }
    public function update_member($id_member,$salary, $role){
        $data_update = [
            'Salaire'=>$salary,
        ];
        if (!empty($role)){
            $data_update['Role'] = $role;
        }
        if($this -> update($id_member, $data_update)){
            return true;
        }else{
            return false;
        }
    }
    public function get_memberRole($id_project, $id_User){
        $role = $this
                -> select('Role')
                -> where('Id_Projet', $id_project)
                -> where('Id_User', $id_User)
                -> first();
        if (isset($role)) {
            return $role -> Role;
        }
        return false;
    }
    public function is_member($id_project, $id_User){
        $member =  $this
            -> where('Id_Projet', $id_project)
            -> where('Id_User', $id_User)
            -> first();

        if (!empty($member)){
            return true;
        }else{
            return false;
        }
    }

    public function addMember($id_user,$project, $role){
        $data_insert =[
            'Id_User'=>$id_user,
            'Id_Projet'=>$project,
            'Role' => $role
        ];
        return $this->insert($data_insert);
    }

}