<?php

// Include the Core class
require_once 'system/Core.php';

// Import necessary classes and namespaces
use System\Core;
use System\Router;

// Create a new Core instance
$core = new Core();

// Automatically load PHP files from specified folders
$core->autoLoad();

// Create a new Router instance
$router = new Router();

// Define a URL prefix for API versioning
$prefix = "/v1";

/*
 * --------------------------------------------------------------------
 * User Controller
 * --------------------------------------------------------------------
 */
$users = "users";
$router->get("$prefix/$users", 'UserController@index');
$router->post("$prefix/$users", 'UserController@store');
$router->get("$prefix/$users/{id}", 'UserController@show');
$router->put("$prefix/$users/{id}", 'UserController@update');
$router->delete("$prefix/$users/{id}", 'UserController@destroy');

// Dispatch the HTTP request to the appropriate controller based on the route
$router->dispatch();