<?php

/**
* The User class.
**/
class User {

	private $username;
	private $password;
	private $posts;

	/**
	* Creates the BlogzaUser instance.
	*
	* @access	public
	* @param 	$username 	The user's display name.
	* @param 	$password 	The user's password (hashed).
	* @param 	$posts 		The amount of posts the user has made.
	* @return 	mixed
	**/
	public function __construct($username, $password, $posts) {
		if($username == null || $password == null || $posts == null) {
			throw new Exception("The username, password, or posts cannot be null!");
		}

		$this->username = htmlspecialchars($username);
		$this->password = htmlspecialchars($password);
		$this->posts = htmlspecialchars($posts);
	}

	/**
	* Gets the username.
	*
	* @access 	public
	* @return 	string 	The username.
	**/
	public function getUsername() {
		return $this->username;
	}

	/**
	* Gets the hashed password.
	*
	* @access 	public
	* @return 	string 	The hashed password.
	**/
	public function getPassword() {
		return $this->password;
	}

	/**
	* Gets the amount of posts from the user.
	*
	* @access 	public
	* @return 	int 	The amount of posts the user has made.
	**/
	public function getPosts() {
		return $this->posts;
	}

	/**
	* Registers a user in the database.
	*
	* @param 	string 	$username 	The requested username of the new user.
	* @param 	string 	$password 	The user's password.
	* @param 	string 	$passwordrep 	The user's password repeated.
	**/
	public static function register($username, $password, $passwordrep) {
		// Checks if the user was missing any fields.
		if(!isset($username) || !isset($password) || !isset($passwordrep)) {
			throw new Exception("All forms must be filled out.");
		}

		// Checks if the user was missing the secret token. TODO

		// Checks if both passwords are equal
		if($password != $passwordrep) {
			throw new Exception("Your passwords do not match.");
		}

		// Do sanitization on the fields. This helps us prevent against shortening in the below process.
		$username    = Util::sanitizeAlphaNumerically($username);
		$password    = Util::sanitizeAlphaNumerically($password);
		$passwordrep = Util::sanitizeAlphaNumerically($passwordrep);

		// Checks if the username is already taken.
		$user = Database::getUser($username);
		if($user != null) {
			throw new Exception("That username is already in use.");
		}

		// Checks if the username and password are of the correct size
		if( !(strlen($password) > 5 && strlen($password) < 21) ) {
			throw new Exception("Your password must be within 6 and 20 characters");
		}

		if( !(strlen($username) > 5 && strlen($username) < 17) ) {
			throw new Exception("Your username must be between 6 and 16 characters.");
		}

		Database::createUser($username, $password);

		Auth::login($username);

		Util::redirect(BLOG_URL);
	}

	/**
	* Logs in a user.
	*
	* @access 	public
	* @param 	string 	$username 	User's username.
	* @param 	string 	$password 	Unhashed given password.
	* @return 	void
	**/
	public static function login($username, $password) {
		// Checks if the user was missing any fields.
		if( !(isset($username) && isset($password)) ) {
			throw new Exception("You didn't include both username and password.");
		}

		// Checks if the user was missing the secret token, TODO

		// Sanitizes the variables
		$username = Util::sanitizeAlphaNumerically($username);
		$password = Util::sanitizeAlphaNumerically($password);

		$password = Util::hashPassword($password);

		$user = Database::getUser($username);
		if($user == null) {
			throw new Exception("Username and/or password incorrect.");
		}

		if($user->getPassword() != $password) {
			throw new Exception("Username and/or password incorrect.");
		}

		Auth::login($username);

		Util::redirect(BLOG_URL);
	}

}