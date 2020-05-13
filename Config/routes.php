<?php

RouteComponent::set('', function () {
    DefaultController::create();
});

RouteComponent::set('home', function () {
    DefaultController::create();
});

RouteComponent::set('tasks', function () {
    DefaultController::create();
});
