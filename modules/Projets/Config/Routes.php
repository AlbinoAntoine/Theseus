<?php
$routes->add("project/(:num)", "Projets::Index/$1", ["namespace" => "\Modules\Projets\Controllers"]);
$routes->add("project/(:num)/step/(:any)", "Projets::step/$1/$2", ["namespace" => "\Modules\Projets\Controllers"]);

$routes->add("action/task_detail", "Projets::get_detailTask", ["namespace" => "\Modules\Projets\Controllers"]);
$routes->add("create_project", "Projets::createProject", ["namespace" => "\Modules\Projets\Controllers"]);
$routes->add("update_project", "Projets::updateProject", ["namespace" => "\Modules\Projets\Controllers"]);
$routes->add("delete_project/(:num)", "Projets::deleteProject/$1", ["namespace" => "\Modules\Projets\Controllers"]);
$routes->add("delete_task/(:num)", "Projets::deleteTask/$1", ["namespace" => "\Modules\Projets\Controllers"]);
$routes->add("leave_project/(:num)", "Projets::leaveProject/$1", ["namespace" => "\Modules\Projets\Controllers"]);
