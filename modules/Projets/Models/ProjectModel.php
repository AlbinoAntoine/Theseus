<?php

namespace Modules\Projets\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table      = 'Projets';
    protected $primaryKey = 'Id_Projet';

    protected $useAutoIncrement = true;

    protected $returnType    = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['Id_Projet', 'CreatedBy', 'Name','Description','Share'];

    protected $useTimestamps = true;
    protected $createdField  = 'Date_Creation';
    protected $updatedField  = 'Date_Update';
//    protected $deletedField  = 'deleted_at';

//    protected $validationRules    = [];
//    protected $validationMessages = [];
//    protected $skipValidation     = false;

    public function get_all($id_user){
        return $this -> where('CreatedBy', $id_user) -> orderBy('Date_Update','DESC') -> find();
    }
    public function get_project($id_project){
        return $this->find($id_project);
    }

    public function get_total($listMembers){
        $time = 0;
        $cost = 0;
        foreach ($listMembers as $member){
            $time += $member['totalTime'];
            $cost += $member['totalTime']*$member['salaire'];
        }
        return $total = ['Time'=> $time,'Cost'=>$cost];
    }

    public function create_project($info){
         $insert_data = [
             'Name'=>$info['title'],
             'Description'=>$info['description'],
             'CreatedBy'=>$_SESSION["Session_User"]["Id_User"],
         ];
         return $this -> insert($insert_data, true);
    }

    public function update_project($info){
        $id_project = $info['idProject'];
        $update_data = [
            'Name'=>$info['title'],
            'Description'=>$info['description'],
        ];
        return $this -> update($id_project,$update_data);
    }
    public function deleteProject($id_project){
        return $this -> where('CreatedBy',$_SESSION["Session_User"]["Id_User"])-> delete($id_project);

    }

    public function get_MemberProject($id_user){
        return $this
            -> select('*, Projets.Id_Projet')
            -> whereNotIn('CreatedBy', [$id_user])
            -> join('Members', 'Projets.Id_Projet = Members.Id_Projet AND Members.Id_User = '.$id_user)
            -> orderBy('Date_Update','DESC')
            -> groupBy('Projets.Id_Projet')
            -> find();
    }
}