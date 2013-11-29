<?php

/**
* The Model for Posts.
**/
class Post extends Model {

	public $title;
	public $author;
	public $content;
	public $date;

	public $link;

	/**
	* Creates the Post instance. Note: This does not load the Post into the database.
	*
	* @access 	public
	* @param 	string 	$title 		The title of the post.
	* @param 	string|User 	$author 	The author of the post.
	* @param 	string 	$content 	The content of the post.
	* @param 	string 	$date 		The creation date of the post.
	* @param 	int 	$id 		The ID of the post. Defaults to null.
	* @return 	Post
	**/
	public function __construct($title, $author, $content, $date, $id) {
		if( !($author instanceof User) ) {
			$author = Database::getUser($author);
		}

		// We use Markup to translate our post stuff.
		$markup = new Markup();

		$this->title = $title;
		$this->author = $author;
		$this->content = $markup->process($content);
		$this->date = $date;

		$this->link = empty($id) ? null : $this->generateUrl($title, $id);
	}

	/**
	* Function for generating the URL for the post.
	*
	* @access 	private
	* @return 	string 	The post URL.
	**/
	private function generateUrl($title, $id) {
		$title = preg_replace("/[^A-Za-z0-9 ]/", "", $title);
		$title = str_replace(" ", "-", $title);
		$title = strtolower($title);

		return "/posts/" . $title . "." . $id . "/";
	}

}