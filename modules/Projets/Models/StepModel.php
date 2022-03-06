<?php

namespace Modules\Projets\Models;

use CodeIgniter\Model;

class StepModel extends Model
{
    protected $table      = 'Steps';
    protected $primaryKey = 'Id_Step';

    protected $useAutoIncrement = true;

    protected $returnType    = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['Id_Step','Id_Projet', 'CreatedBy', 'Name','Step_Order'];

    protected $useTimestamps = true;
    protected $createdField  = 'Date_Creation';
    protected $updatedField  = 'Date_Update';
//    protected $deletedField  = 'deleted_at';

//    protected $validationRules    = [];
//    protected $validationMessages = [];
//    protected $skipValidation     = false;

    public function get_all($id_projet){
        return $this
            -> select('*, Steps.Id_Step, SUM(Tasks.Duration)/10000 as Time')
            -> join('Tasks','Tasks.Id_Step = Steps.Id_Step', 'LEFT')
            -> where('Steps.Id_Projet', $id_projet)
            -> groupBy('Steps.Id_Step')
            -> orderBy('Step_Order','ASC')
            -> find();

    }
    public function get_step($id_step){
        return $this -> select() -> find($id_step);
    }

    /**
     * @param $id_user
     * @param $id_project
     * @return bool
     * @throws \ReflectionException
     * Create empty task
     */
    public function new_step($id_user, $id_project){

        $data_update = [
            'Id_Projet' => $id_project,
            'CreatedBy' => $id_user,
            'Name' => 'New Step',
            'Description' => '',
            'Step_Order'=> $this->numOfStep($id_project)+1
        ];
        return $this -> insert($data_update);
    }

    public function update_title($id_step, $title){
        $data_update =[
          'Name' => $title
        ];
        return $this -> update($id_step,$data_update);
    }
    public function numOfStep($id_project){
        return $this -> where('Id_Projet', $id_project) -> countAllResults();
    }
}