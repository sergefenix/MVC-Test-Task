<?php

RouteComponent::set('', function () {
    DefaultController::home('home');
});

RouteComponent::set('create', function () {
    DefaultController::create('create');
});

RouteComponent::set('edit', function () {
    DefaultController::edit('edit');
});

RouteComponent::set('404', function () {
    DefaultController::error('404');
});
