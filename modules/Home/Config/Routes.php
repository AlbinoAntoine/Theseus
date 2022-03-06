<?php
$routes->add("/", "HomePage::index", ["namespace" => "\Modules\Home\Controllers"]);
$routes->add("projects", "HomePage::index", ["namespace" => "\Modules\Home\Controllers"]);
$routes->add("contribute", "HomePage::contribute", ["namespace" => "\Modules\Home\Controllers"]);
