<?php

namespace Modules\Projets\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table      = 'Tasks';
    protected $primaryKey = 'Id_Task';

    protected $useAutoIncrement = true;

    protected $returnType    = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['Id_Projet','Id_Step','Titre', 'Note','Priority','Validate','Id_User', 'Duration'];

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = '';
//    protected $deletedField  = 'deleted_at';

//    protected $validationRules    = [];
//    protected $validationMessages = [];
//    protected $skipValidation     = false;
    public function add_Task($id_projet, $id_step, $titre){
        $maxOrder = $this -> select('MAX(Priority) as MaxOrderTask') -> where('Id_Step', $id_step) -> find();

        $data_insert=[
            'Id_Projet'=>$id_projet,
            'Id_Step'=>$id_step,
            'Titre'=>$titre,
            'Note'=>'',
        ];
        return $this->insert($data_insert, true);
    }
    public function get_stepTasks($id_step){
        $Tasks = $this
            -> where('Id_Step', $id_step)
            -> where('Priority', 0)
            -> orderBy('Date_Update','ASC')
            -> find();
        $TasksWithPriority = $this
            -> where('Id_Step', $id_step)
            -> whereNotIn('Priority', [0])
            -> orderBy('Priority','ASC')
            -> orderBy('Date_Update','ASC')
            -> find();

        return array_merge($TasksWithPriority,$Tasks);
    }
    public function get_task($id_task){
        return $this -> find($id_task);
    }
    /**
     * @param $id_project
     * Return the number of task in a project
     */
    public function numOfTask($id_project){
        return $this -> where('Id_Projet', $id_project) -> countAllResults();
    }

    public function compte_pourcentage($id_step){
        $tasks =$this -> get_stepTasks($id_step);
        $total = 0;
        $taskDone = 0;
        foreach ($tasks as $task){
            $time = 1;
            if ($task->Duration != '00:00:00'){
                $time = date('G',strtotime($task->Duration));
            }
            if ($task->Validate == 1){
                $taskDone += $time;
            }
            $total += $time;
        }
        if ($total == 0) $total = 1;
        return round(($taskDone / $total) * 100).'%';
    }
    public function check_Task($val,$id_task){
        $this -> update($id_task,['Validate' => $val]);
    }
    public function save_Task($info){
        $data = [
            'Titre'=>$info['title'],
            'Duration'=> $info['duration'].':00',
            'Note'=>$info['note'],
            'Id_User'=>$info['member'],
            'Priority'=>$info['priority'],
        ];
        if($this -> update($info['id_task'],$data)){
            return true;
        }else{
            return false;
        }
    }
    public function deleteTask($id_task){
        return $this -> delete($id_task);
    }
}