<?php
if(isset($_GET['id']) && $_GET['id'] != "") {
	$id = intval($_GET['id']);
} else {
	header("Location: ./");
	exit();
}
include('./includes/wrapper.php');
$template = new Template('index.tpl');

foreach($postHandler->getAllTaggedPosts($id) as $post) {
	$row = new Template('post_preview.tpl');
	$row->set('postID', $post->id);
	$row->set('postTitle', $post->title);
	$row->set('postPreview', substr($post->content, 0, 50));
	$row->set('date', $post->date_posted);
	$row->set('author', $post->author->getFullname());
	$postsTemplate[] = $row;
}

$tagString = "";
foreach($postHandler->tags as $tag) {
	$tagString = $tagString . "<b><a href='tag.php?id=".$tag->id."'>".$tag->name."</a></b>, ";
}

$tagString = substr($tagString, 0, -2);
$postString = isset($postsTemplate) ? Template::merge($postsTemplate) : "<h2>No posts found with that tag!</h2>";

$template->set('title', 'personal blog');
$template->set('desc', 'my very own personal blog');
$template->set('tags', $tagString);
$template->set('posts', $postString);

echo $template->output();
?>