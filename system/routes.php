<?php

/* ----------------------------------------
 | This file contains the file routes.
 | ----------------------------------------
 | If you want to create your own pages,
 | or modify the controller for a page,
 | this is the place. Here is a list of
 | every page for the simplicity of users.
 */

 /*
 | Route style:
 | $this->router->get('/path/to/page', 'FileName.controller.php@ControllerClass@methodForRoute');
 */

// NOTICE: After installation, comment out these lines. (Put a // in front of both)
$this->router->get('/install/', 'InstallerController@start');
$this->router->get('/install/step/([1-3])', 'InstallerController@step');


$this->router->get('/', 'PostController@index');

$this->router->get('/register/', 'AuthenticationController@register');
$this->router->get('/login/', 'AuthenticationController@login');
$this->router->get('/logout/', 'AuthenticationController@logout');

$this->router->get('/post/([0-9]+)', 'PostController@viewPost');

$this->router->get('/admin/', 'AdminController@index');
$this->router->get('/admin/create-post', 'AdminController@createPost');


$this->router->any('404', 'HTTPErrorController@display404');