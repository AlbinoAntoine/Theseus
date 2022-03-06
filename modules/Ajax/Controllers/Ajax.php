<?php

namespace Modules\Ajax\Controllers;

use App\Controllers\BaseController;
use Modules\Auth\Models\UsersModel;
use Modules\Projets\Models\MemberModel;
use Modules\Projets\Models\ProjectModel;
use Modules\Projets\Models\StepModel;
use Modules\Projets\Models\TaskModel;

class Ajax extends BaseController
{
    public function __construct()
    {
        $this->ProjectModel = new ProjectModel();
        $this->StepModel = new StepModel();
        $this->TaskModel = new TaskModel();
        $this->MemberModel = new MemberModel();
        $this->UsersModel = new UsersModel();
    }
    public function addTask(){

        if (empty($_POST)){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $id_task = $this->TaskModel->add_Task($_POST['idProject'], $_POST['idStep'], $_POST['titleTask']);

        $data=[
            'titre' => $_POST['titleTask'],
            'id_task'=> $id_task
        ];
        return view('Modules\Ajax\Views\Task', $data);
    }
    public function checkTask(){
        if (empty($_POST['id'])){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->TaskModel->check_Task($_POST['checked'],$_POST['id']);
        return true;
    }
    public function saveTask(){
        if (empty($_POST)){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if($this->TaskModel->save_Task($_POST)){
            return 'true';
        }else{
            return 'false';
        }
    }
    public function updateProgress(){
        echo $this->TaskModel->compte_pourcentage($_POST['id_step']);
    }

    public function updateMember(){
        if($this->MemberModel->update_member($_POST['member_id'], $_POST['salary'],$_POST['role'] ?? null )){
            return 'true';
        }else{
            return 'false';
        }
    }
    public function updateTitleStep(){
        if (empty(trim($_POST['title']))){
            return 'false';
        }
        if($this->StepModel->update_title($_POST['idStep'],$_POST['title'])){
            return 'true';
        }else{
            return 'false';
        }
    }

    public function modal_createProject(){
        return view('Modules\Ajax\Views\create_project');
    }
    public function modal_modifyProject($id_project){
        $project = $this->ProjectModel->get_project($id_project);
        $data=[
            'project' => $project
        ];
        return view('Modules\Ajax\Views\update_project', $data);
    }

    public function modal_deleteTask($id_task){
        $Task = $this->TaskModel->get_task($id_task);
        $lastUrl = $_POST['url'];
        $data=[
            'Task' => $Task,
            'lastUrl'=>$lastUrl
        ];
        return view('Modules\Ajax\Views\delete_task', $data);
    }

    public function modal_addMember($id_project){
        $project = $this->ProjectModel->get_project($id_project);

        $data=[
            'project' => $project,
        ];
        return view('Modules\Ajax\Views\add_member', $data);
    }
    public function searchUser(){
        $research = $_POST['research'];
        $project = $_POST['project'];
        $members = $this->UsersModel->findUser($research,$project);

        $data=[
            'members' => $members,
        ];
        return view('Modules\Ajax\Views\searchUser', $data);
    }
    public function AddMember(){
        $id_user = $_POST['id_user'];
        $project = $_POST['project'];
        if($this->MemberModel->addMember($id_user,$project,1)){
            echo '<div class="alert alert-member alert-success" role="alert">User added to this project</div>';
        }else{
            echo '<div class="alert alert-member alert-danger" role="alert">An error has occurred</div>';
        }

    }
    public function removeMember(){
        $member = $this->MemberModel->find($_POST['idMember']);

        if (!empty($member) && $this->MemberModel->is_member($member->Id_Projet, $_SESSION['Session_User']['Id_User'])!==false && $member->Role != 0){
            if ($this->MemberModel->delete($_POST['idMember'])){
                echo 'true';
            }
        }else echo 'false';

    }
}