<?php
$routes->add("action/add_task", "Ajax::addTask", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/check_task", "Ajax::checkTask", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/save_task", "Ajax::saveTask", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/update_progress", "Ajax::updateProgress", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/update_member", "Ajax::updateMember", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/update_step_title", "Ajax::updateTitleStep", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/modal_create_project", "Ajax::modal_createProject", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/modal_modify_project/(:num)", "Ajax::modal_modifyProject/$1", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/modal_delete_task/(:num)", "Ajax::modal_deleteTask/$1", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/modal_add_member/(:num)", "Ajax::modal_addMember/$1", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/search_user", "Ajax::searchUser", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/add_member", "Ajax::AddMember", ["namespace" => "\Modules\Ajax\Controllers"]);
$routes->add("action/remove_member", "Ajax::removeMember", ["namespace" => "\Modules\Ajax\Controllers"]);
