<?php
include("./includes/post.php");
include("./includes/tag.php");

class PostHandler {
	public $posts = array();
	public $tags = array();
	private $db;
	
	public function __construct() {
        $this->db = DB::getInstance();
		$this->getTags();
		$this->getPosts();
    }
	
	public function getTags() {
		$this->tags = array();
		$query = "SELECT * FROM tags";
		$results = $this->db->get_results( $query );
		foreach( $results as $row ) {
			$tagObj = new Tag($row['id'], $row['name'], $row['description']);
			array_push($this->tags, $tagObj);
		}
	}
	
	public function getTagById($id) {
		foreach($this->tags as $tag) {
			if($tag->id == $id) {
				return $tag;
			}
		}
		return -1;
	}
	
	public function getPosts() {
		$this->posts = array();
		$query = "SELECT * FROM posts";
		$results = $this->db->get_results( $query );
		foreach( $results as $row ) {
			list( $uid, $email, $pw, $firstName, $lastName, $rank, $sessionCode) = $this->db->get_row( "SELECT * FROM users WHERE id = '".$row['author_id']."'" );
			$author = new User($uid, $email, $firstName, $lastName, $rank);
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
			$post = new Post($row['id'], $row['title'], $row['post'], $author, $row['date_posted'], $posttags);
			array_push($this->posts, $post);
		}
	}
	
	public function getPostById($id) {
		foreach($this->posts as $post) {
			if($post->id == $id) {
				return $post;
			}
		}
		return -1;
	}
	
	public function getAllTaggedPosts($tagId) {
		$foundPosts = array();
		foreach($this->posts as $post) {
			foreach($post->tags as $tag) {
				if($tag->id == $tagId) {
					array_push($foundPosts, $post);
				}
			}
		}
		return $foundPosts;
	}		
	
	public function deletePost($post) {
		$delete = array(
			'id' => $post->id
		);
		return $this->db->delete( 'posts', $delete, 1 );
	}
	
	public function updatePost($post) {
		$update = array(
			'title' => $post->title, 
			'post' => $post->content,
			'author_id' => $post->author->getFullname()
		);
		$where = array(
			'id' => $post->id
		);
		return $this->db->update('posts', $update, $where, 1);
	}
	
	public function addPost($post) {
		$postInfo = array(
			'title' => $post->title,
			'post' => $post->content,
			'author' => $post->author->id,
			'date_posted' => date("Y-n-j")
		);
		return $this->db->insert( 'posts', $postInfo );
	}
	
	public function removeTag($postId, $tagId) {
		$delete = array(
			'post_id' => $postId,
			'tag_id' => $tagId
		);
		return $this->db->delete( 'post_tags', $delete, 1 );
	}
	
	public function addTag($postId, $tagId) {
		$tags = array(
			'post_id' => $postId,
			'tag_id' => $tagId
		);
		return $this->db->insert( 'post_tags', $tags );
	}
}
?>