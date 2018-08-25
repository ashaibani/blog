<?php
class User {
	private $id;
	public $email;
	public $firstName;
	public $lastName;
	public $rank;
	
	public function __construct($id, $email, $firstName, $lastName, $rank) {
		$this->id = $id;
		$this->email = $email;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->rank = $rank;
	}
	
	public function getFullname() {
		return $this->firstName . ' ' . $this->lastName;
	}
	
	public function isAdmin() {
		return ($this->rank == 2);
	}
}
?>