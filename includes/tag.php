<?php
class Tag {
	public $id;
	public $name;
	public $description;
		
	public function __construct($id, $name, $description) {
        $this->id = $id;
		$this->name = $name;
		$this->description = $description;
    }
}
?>