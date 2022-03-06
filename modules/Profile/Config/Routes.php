<?php
$routes->add("profile/(:num)", "Profile::profile/$1", ["namespace" => "\Modules\Profile\Controllers"]);
$routes->add("profile/(:num)/update_image", "Profile::updatePP/$1", ["namespace" => "\Modules\Profile\Controllers"]);
