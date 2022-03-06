<?php
$routes->add("connexion", "Auth::connexion", ["namespace" => "\Modules\Auth\Controllers"]);

$routes->add("register", "Auth::register", ["namespace" => "\Modules\Auth\Controllers"]);
$routes->add("login", "Auth::login", ["namespace" => "\Modules\Auth\Controllers"]);
$routes->add("password_forgotten", "Auth::forgotten_password", ["namespace" => "\Modules\Auth\Controllers"]);


$routes->add("logout", "Auth::logout", ["namespace" => "\Modules\Auth\Controllers"]);


$routes->group("theseAdmin", ["namespace" => "\Modules\Auth\Controllers"], function ($routes) {

    $routes->add("login", "AdminAuth::login");
    $routes->add("mot-de-passe-oublie", "AdminAuth::forgotten_password");
    $routes->add("reinitialisation-mot-de-passe/(:num)/(:alpha)", "AdminAuth::reset_password/$1/$2");
    $routes->add("deconnexion", "AdminAuth::logout", ["namespace" => "\Modules\Auth\Controllers"]);
});

