<?php

/**
* The ModelManager class, which appropriates the Routing and then the Models.
*
* @author	boboman13 <me@boboman13.net>
* @version	1.0
**/
class ModelManager {

	protected $router;

	/**
	* Creates an instance of the ModelManager class.
	*
	* The ModelManager class is a class that, simply, manages all the models. This class is also responsible for the correct
	*  routing and route management, then selecting the correct Model to utilize for
	*
	* @access 	public
	* @return 	ModelManager
	**/
	public function __construct() {
		require "Router.class.php";
		$this->router = new Router();
	}

	/**
	* Prepares the ModelManager.
	*
	* This includes preparing the Router with the Models necessary.
	*
	* @access 	public
	* @return 	void
	**/
	public function prepare() {
		$this->prepareRouter();
	}

	/**
	* Launches the ModelManager class.
	*
	* This function begins by resolving the correct route and page the user accessed, then it gets the necessary data from 
	*  the correct model.
	*
	* @access 	public
	* @return 	void
	**/
	public function go() {
		// Gets the Router's correct controller
		$res = $this->router->go();

		if($res == null) $res = "404.controller.php@NotFound@display";

		// Split it by '@', which gives us the file, class, and method name.
		list($file, $class, $method) = explode("@", $res);

		// Give the Controller the matched expressions it wants.
		$matched = $this->router->getMatchedExpressions();

		// Require the $file for the controller and create the $class.
		require BLOGZA_DIR . "/system/controllers/" . $file;
		$controller = new $class($matched);

		// Run the method.
		$controller->$method();
	}

	/**
	* Prepares the Router by adding all the Models and their routes.
	*
	* @access 	private
	* @return 	void
	**/
	private function prepareRouter() {
		// Require what the controller needs to implement
		require BLOGZA_DIR . "/system/controllers/Controller.php";

		// Get the routes.
		require BLOGZA_DIR . "/system/routes.php";

		foreach($routes as $route => $class) {
			$this->router->addRoute($route, $class);
		}

	}

}