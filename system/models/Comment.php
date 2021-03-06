<?php

/**
* A single instance of a Comment.
**/
class Comment {

	public $id;
	public $post;
	public $author;
	public $ismoderated;
	public $date;
	public $content;

	/**
	* Creates a Comment instance.
	*
	* @access 	public
	* @param 	int 	$id 	ID of the comment.
	* @param 	int 	$post 	ID of the post.
	* @param 	User	$author 	The comment's author.
	* @param 	bool 	$ismoderated 	Whether or not the comment has been moderated yet. Not used on all systems.
	* @param 	string 	$content 	The content of the post.
	* @param 	string 	$date 	The date at which the comment was made.
	* @return 	Comment
	**/
	public function __construct($id, $post, $author, $ismoderated, $content, $date) {
		$markup = new Markup();

		$this->id = htmlentities($id);
		$this->author = $author;
		$this->ismoderated = htmlentities($ismoderated);
		$this->content = $markup->process(htmlentities(stripslashes($content))); // Call htmlentities() BEFORE Markup.
		$this->date = htmlentities($date);
	}

}