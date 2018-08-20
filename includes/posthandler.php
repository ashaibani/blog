<?php
include("./includes/post.php");
include("./includes/tag.php");

class PostHandler {
	public $posts = array();
	public $tags = array();
	private $db;
	
	public function __construct($db) {
        $this->db = $db;
		$this->getTags();
		$this->getPosts();
    }
	
	public function getTags() {
		$query = "SELECT * FROM tags";
		$results = $this->db->get_results( $query );
		foreach( $results as $row ) {
			$tagObj = new Tag($row['id'], $row['name'], $row['description']);
			array_push($this->tags, $tagObj);
		}
	}
	
	public function getPosts() {
		$query = "SELECT * FROM posts";
		$results = $this->db->get_results( $query );
		foreach( $results as $row ) {
			$authorResult = $this->db->get_row( "SELECT * FROM users WHERE id = '".$row['author_id']."'" );
			$posttags = array();
			$tagResults = $this->db->get_results( "SELECT * FROM post_tags WHERE post_id = '".$row['id']."'" );
			if(count($tagResults) > 0) {
				foreach( $tagResults as $tag_id ) {
					foreach($this->tags as $tagObj) {
						if($tagObj->id == $tag_id['tag_id']) {
							array_push($posttags, $tagObj);
						}
					}
				}
			}
			$post = new Post($row['id'], $row['title'], $row['post'], $authorResult, $row['date_posted'], $posttags);
			array_push($this->posts, $post);
		}
	}
}
?>