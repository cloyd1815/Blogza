<?php

class TemplateManager {

	private $page;
	private $blogza;

	/**
	* Creates the TemplateManager instance.
	*
	* @param	string	$template	The name of the template file to use.
	* @return	void
	**/
	public function __construct($blogza) {
		$this->blogza = $blogza;

		//$this->loadTemplate($template);
	}

	/**
	* Loads the template from the files.
	*
	* @access	public
	* @return	void
	**/
	public function loadTemplate($pages, $template = "default") {
		$location = __DIR__.'/../templates/'.$template.'/';

		// Go through the routes system to grab the necessary files.
		foreach($pages as $page) {
			$this->page .= file_get_contents($location.$page);
		}

		$this->processPage();
	}

	/**
	* Processes the page. This includes changing all variables to their specified values.
	*
	* @return	void
	**/
	private function processPage() {

		/* An array of settings and values to change. */
		$replaceables = array(
			"{blog-name}" => BLOG_NAME,
			"{blog-description}" => BLOG_DESC,
			// Custom variables
			"{date}" => date("M-D-Y"),
			"{date-year}" => date("Y"),
			);

		/* Now lets retrieve all the posts */
		$posts = $this->blogza->getDatabaseManager()->getPosts(); // Gets all the posts.

		foreach($posts as $post) {
			$postID = $post['id'];
			$inverseID = (count($posts) - $postID) + 1;

			$replaceables["{post-".$postID."-author}"] = $post['author'];
			$replaceables["{post-".$postID."-title}"] = $post['title'];
			$replaceables["{post-".$postID."-content}"] = $post['content'];
			$replaceables["{post-".$postID."-link}"] = $post['link'];
			$replaceables["{post-".$postID."-date}"] = $post['date'];
			// Now do latest posts.
			$replaceables["{latest-".$inverseID."-author}"] = $post['author'];
			$replaceables["{latest-".$inverseID."-title}"] = $post['title'];
			$replaceables["{latest-".$inverseID."-content}"] = $post['content'];
			$replaceables["{latest-".$inverseID."-link}"] = $post['link'];
			$replaceables["{latest-".$inverseID."-date}"] = $post['date'];
		}

		foreach($replaceables as $key => $value) {
			$this->page = str_replace($key, $value, $this->page);
		}

		$this->displayPage();
	}

	/**
	* Displays the page.
	*
	* @return	void
	**/
	public function displayPage() {
		echo $this->page;
	}
	
}