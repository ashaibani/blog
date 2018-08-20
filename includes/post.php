<?php
class Post {
	public $id;
	public $title;
	public $content;
	public $author;
	public $date_posted;
	public $tags = array();
		
	public function __construct($id, $title, $content, $author, $date_posted, $tags) {
        $this->id = $id;
		$this->title = $title;
		$this->content = $content;
		$this->author = $author;
		$this->date_posted = $date_posted;
		$this->tags = $tags;
    }
}
?>