<?php

class Home extends Controller {

	public function __construct() {
		
	}

	public function start() {
		$view = BLOGZA_DIR . "/system/views/Home.view.php";

		// Prepare the variables needed for the View, then start the View.
		$posts = Database::getPosts();

		require $view;
	}

	public function getRoute() {
		return "/";
	}

}