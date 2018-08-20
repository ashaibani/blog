<?php
include('./includes/wrapper.php');

$template = new Template('index.tpl');

foreach($postHandler->posts as $post) {
	$row = new Template('post_preview.tpl');
	$row->set('postID', $post->id);
	$row->set('postTitle', $post->title);
	$row->set('postPreview', $post->content);
	$row->set('date', $post->date_posted);
	$row->set('author', $post->author[3] . " " . $post->author[4]);
	$postsTemplate[] = $row;
}

$tagString = "";
foreach($postHandler->tags as $tag) {
	$tagString = $tagString . "<b><a href='tag.php?id=".$tag->id."'>".$tag->name."</a></b>, ";
}

$tagString = substr($tagString, 0, -2);
$postString = Template::merge($postsTemplate);

$template->set('title', 'personal blog');
$template->set('tags', $tagString);
$template->set('posts', $postString);
/*
	[@postID]
	[@postPreview]
	[@date]
	[@author]
	[@postTitle]
	[@tags] = <b><a href="category.html">Field</a></b>, <a href="category.html"><b>Category</b></a>, <a href="category.html"><b>Empty</b></a>
*/
echo $template->output();
?>