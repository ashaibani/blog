<?php
if(isset($_GET['id']) && $_GET['id'] != "") {
	$id = $_GET['id'];
} else {
	header("Location: ./");
	exit();
}
include('./includes/wrapper.php');

$template = new Template('post.tpl');
$post = $postHandler->getPostById($id);

$tagString = "";
foreach($post->tags as $tag) {
	$tagString = $tagString . "<b><a href='tag.php?id=".$tag->id."'>".$tag->name."</a></b>, ";
}
$tagString = substr($tagString, 0, -2);

$template->set('postID', $post->id);
$template->set('postTitle', $post->title);
$template->set('postContent', $post->content);
$template->set('date', $post->date_posted);
$template->set('author', $post->author->getFullname());
$template->set('postTags', $tagString);

$tagString = "";
foreach($postHandler->tags as $tag) {
	$tagString = $tagString . "<b><a href='tag.php?id=".$tag->id."'>".$tag->name."</a></b>, ";
}

$tagString = substr($tagString, 0, -2);

$template->set('title', 'personal blog');
$template->set('tags', $tagString);

echo $template->output();
?>