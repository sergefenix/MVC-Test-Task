<?php

use Components\Route;

$rout = new Route();
$path = '/TaskManager/';

try {

    // Task routes
    $rout->get("{$path}", static function () use ($rout) {
        $rout->createRoute('TaskController', 'home');
    });

    $rout->post("{$path}create", static function () use ($rout) {
        $rout->createRoute('TaskController', 'create');
    });

    $rout->get("{$path}create_form", static function () use ($rout) {
        $rout->createRoute('TaskController', 'create_form');
    });

    $rout->get("{$path}delete", static function () use ($rout) {
        $rout->createRoute('TaskController', 'delete_tasks');
    });

    $rout->post("{$path}update", static function () use ($rout) {
        $rout->createRoute('TaskController', 'update_tasks');
    });

    $rout->get("{$path}update_form", static function () use ($rout) {
        $rout->createRoute('TaskController', 'update_task_form');
    });

    // User routes
    $rout->post("{$path}register", static function () use ($rout) {
        $rout->createRoute('UserController', 'register');
    });

    $rout->get("{$path}login", static function () use ($rout) {
        $rout->createRoute('UserController', 'login');
    });

    $rout->post("{$path}login_user", static function () use ($rout) {
        $rout->createRoute('UserController', 'login_user');
    });

    $rout->get("{$path}logout", static function () use ($rout) {
        $rout->createRoute('UserController', 'logout');
    });

    // Metagram routes
    $rout->get("{$path}Metagram", static function () use ($rout) {
        $rout->createRoute('FindWayForWord', 'index');
    });

    $rout->post("{$path}Metagram/create", static function () use ($rout) {
        $rout->createRoute('FindWayForWord', 'create');
    });

} catch (Exception $e) {
}

$rout->createRoutes();