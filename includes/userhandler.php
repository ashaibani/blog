<?php
include("./includes/user.php");

class UserHandler {
	private $db;
	public static $instance;
	public $users = array();
	
	public function __construct() {
        $this->db = DB::getInstance();
    }
	
	public function getUsers() {
		
	}
	
	public function getUserById($id) {
		$query = "SELECT * FROM users WHERE id = '".$id."'";
		if($this->db->num_rows( $query ) > 0 ) {
			list( $uid, $email, $pw, $firstName, $lastName, $rank, $sessionCode) = $this->db->get_row( $query );
			return new User($uid, $email, $firstName, $lastName, $rank);
		} else {
			return false;
		}
	}
	
	public function getUserBySessioncode($sessionCode) {
		$query = "SELECT * FROM users WHERE sessionCode = '".$sessionCode."'";
		if($this->db->num_rows( $query ) > 0 ) {
			list( $uid, $email, $pw, $firstName, $lastName, $rank, $sessionCode) = $this->db->get_row( $query );
			return new User($uid, $email, $firstName, $lastName, $rank);
		} else {
			return false;
		}
	}
	
	public function login($email, $password) {
		$query = "SELECT * FROM users WHERE email = '".$row['author_id']."' AND password = '".$password."'";
		if($this->db->num_rows( $query ) > 0 ) {
			list( $uid, $email, $pw, $firstName, $lastName, $rank, $sessionCode) = $this->db->get_row( $query );
			$sessionCode = generateSessionCode($uid);
			if($sessionCode == false) {
				return false;
			} else {
				setcookie("sessionCode", $sessionCode);
				return new User($uid, $email, $firstName, $lastName, $rank);
			}
		} else {
			return false;
		}
	}
	
	public function userExists($email) {
		$query = "SELECT * FROM users WHERE email = '".$email."'";
		if($this->db->num_rows( $query ) > 0 ) {
			list( $uid, $email, $pw, $firstName, $lastName, $rank, $sessionCode) = $this->db->get_row( $query );
			return new User($uid, $email, $firstName, $lastName, $rank);
		} else {
			return false;
		}
	}
	
	public function addUser($user, $password) {
		$userInfo = array(
			'email' => $user->email,
			'password' => $password,
			'first_name' => $user->firstName,
			'last_name' => $user->lastName,
			'rank' => $user->rank
		);
		return $this->db->insert( 'users', $userInfo );
	}
	
	public function deleteUser($id) {
		$delete = array(
			'id' => $id
		);
		return $this->db->delete( 'users', $delete, 1 );
	}
	
	function generateSessionCode($id) {
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$sessionCode = '';
		for ($i = 0; $i < $length; $i++) {
			$sessionCode .= $characters[rand(0, $charactersLength - 1)];
		}
		$update = array(
			'sessionCode' => $sessionCode
		);
		$where = array(
			'id' => $id
		);
		$updated = $this->db->update('users', $update, $where, 1);
		if($updated) {
			return $sessionCode;
		} else {
			return false;
		}
	}
	
	public static function get() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
?>