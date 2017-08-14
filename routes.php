<?php
include 'controllers/services.php';
include 'controllers/home.php';
include 'controllers/reservations.php';
include 'controllers/locations.php';

# Statis routes
$router->addRoute('GET', '/version', false, $home['version']);
$router->addRoute('GET', '/', false, $home['index']);

# Auth routes POST username and password
$router->addRoute('POST', '/auth', false, function() { return auth_create_token($_POST['username'], $_POST['password']); });
$router->addRoute('POST', '/register', false, function() {
    return register($_POST['email'], $_POST['username'], $_POST['password']);
});

# GET 
$router->addRoute('GET', '/reservations', true, $reservations['index']);
# List of all locations
$router->addRoute('GET', '/locations', true, $locations['index']);
$router->addRoute('GET', '/services', false, $services['index']);
$router->addRoute('GET', '/dates', true, function() {});
$router->addRoute('GET', '/times', true, function() {});

$router->addRoute('POST', '/reservations', true, $reservations['create']);
$router->addRoute('POST', '/cancel', true, $reservations['cancel']);