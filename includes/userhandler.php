<?php
include("./includes/user.php");

class UserHandler {
	private $db;
	
	public function __construct($db) {
        $this->db = $db;
    }
}
?>