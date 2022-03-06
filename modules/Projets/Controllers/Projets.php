<?php

namespace Modules\Projets\Controllers;

use App\Controllers\BaseController;
use Modules\Projets\Models\MemberModel;
use Modules\Projets\Models\ProjectModel;
use Modules\Projets\Models\StepModel;
use Modules\Projets\Models\TaskModel;

class Projets extends BaseController
{
    public function __construct()
    {
        $this->ProjectModel = new ProjectModel();
        $this->StepModel = new StepModel();
        $this->TaskModel = new TaskModel();
        $this->MemberModel = new MemberModel();
    }

    public function index($id_projet)
    {
        $projet = $this-> ProjectModel -> find($id_projet);
        if (empty($projet)){
            echo "<p>This project doesn't exist</p>";
            die();
        }
        $is_role = $this-> MemberModel -> get_memberRole($id_projet, $_SESSION['Session_User']['Id_User']);

        if ($is_role === false){
            echo "<p>You don't have access to this project</p>";
            die();
        }

        $listSteps = $this->StepModel -> get_all($id_projet);
        $listMembers = $this->MemberModel->get_memberInfo($id_projet);
        $total = $this->ProjectModel->get_total($listMembers);

        $pourcentage=[];
        foreach($listSteps as $step){
            $pourcentage[$step->Id_Step] = $this->TaskModel -> compte_pourcentage($step->Id_Step);
        }

        $data =[
            'title' => 'Projet | '.$projet->Name,
            'projet'=> $projet,
            'listSteps' => $listSteps,
            'pourcentage' => $pourcentage,
            'listMembers' => $listMembers,
            'total'=>$total,
            'is_role' =>$is_role
        ];

        return view('Modules\Projets\Views\singleProject', $data);
    }

    /**
     * @throws \ReflectionException
     */
    public function step($id_projet, $id_step)
    {
        helper('form');
        $projet = $this->ProjectModel -> find($id_projet);
        if (empty($projet)){
            echo "<p>This project doesn't exist</p>";
        }
        $is_role = $this->MemberModel -> get_memberRole($id_projet, $_SESSION['Session_User']['Id_User']);

        if ($is_role === false){
            echo "<p>You don't have access to this project</p>";
            die();
        }

        if ($id_step == 'new_step'){
            $newstep = $this-> StepModel -> new_step($_SESSION['Session_User']['Id_User'], $id_projet);
            if ($newstep !=false){
                return redirect()->to(site_url('/project/'.$id_projet.'/step/'.$newstep));
            }
        }
        if (!empty($_POST['addTask'])){
            $this->TaskModel->add_Task($id_projet, $id_step,$_POST['addTask']);
        }

        $listMembers = $this->MemberModel->get_member($id_projet);

        $step = $this-> StepModel -> get_step($id_step);

        $listTasks = $this->TaskModel -> get_stepTasks($id_step);
        $pourcentage = $this->TaskModel -> compte_pourcentage($id_step);

        $data =[
            'title' => 'Step | '.$step->Name ?? 'New',
            'projet'=>$projet,
            'step'=> $step,
            'pourcentage' => $pourcentage,
            'listTasks' => $listTasks,
            'listMembers' => $listMembers,
        ];

        return view('Modules\Projets\Views\singleStep', $data);
    }

    public function get_detailTask(){
        helper('form');
        $task = $this->TaskModel -> get_task($_POST['task_id']);
        $step = $this->StepModel -> get_step($task->Id_Step);
        $listMembers = $this->MemberModel->get_member($step->Id_Projet);

        $data =[
            'task'=> $task,
            'listMembers' => $listMembers
        ];

        return view('Modules\Projets\Views\partial\detail_task.php', $data);
    }
    public function createProject(){
        $id_project = $this->ProjectModel->create_project($_POST);
        if ($id_project != false){
            $this->MemberModel->addMember($_SESSION['Session_User']['Id_User'], $id_project, 0);
            return redirect()->to(site_url('project/'.$id_project));
        }else{
            return redirect()->to(site_url());
        }
    }
    public function updateProject(){
        $this->ProjectModel -> update_project($_POST);
        return redirect()->to(site_url());
    }
    public function deleteProject($id_project){
        $this->ProjectModel -> where('CreatedBy',$_SESSION['Session_User']['Id_User']) -> deleteProject($id_project);
        return redirect()->to('/');
    }
    public function deleteTask($id_task){
        $this->TaskModel->deleteTask($id_task);
        return redirect()->to(base64_decode($_GET['lastUrl']));
    }
    public function leaveProject($id_project){
        $this->MemberModel->where('Id_Projet', $id_project)->where('Id_User', $_SESSION['Session_User']['Id_User']) ->delete();
        return redirect()->to(site_url('project/'.$id_project));
    }
}
