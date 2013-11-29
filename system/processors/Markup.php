<?php

/**
* The Markup class, used for marking up comments and posts.
**/
class Markup {

	private $markups = array(
		"[BOLD]" => "<b>",
		"[/BOLD]" => "</b>",
		"[ITALIC]" => "<i>",
		"[/ITALIC]" => "</i>",
		);

	/**
	* Creates the Markup instance.
	*
	* @access 	public
	* @return 	Markup
	**/
	public function __construct() {

	}

	/**
	* Processes the given text into our Markup.
	*
	* @access 	public
	* @param 	string 	$text 	The text to process into Markup.
	* @return 	string 	Processed text.
	**/
	public function process($text) {
		// Goes through all of $markups and switches.
		foreach($this->markups as $tag => $repl) {
			$text = str_replace($tag, $repl, $text);
		}

		return $text;
	}

}