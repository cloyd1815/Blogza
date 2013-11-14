<?php

$view = new View(BLOG_TEMPLATE);

$pages = array(
	"header.tpl",
	"navigation.tpl",
	"404.tpl",
	"footer.tpl",
	);

foreach($pages as $page) {
	$view->loadPage($page);
}