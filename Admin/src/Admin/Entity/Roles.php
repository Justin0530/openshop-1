<?php
namespace Admin\Entity;

class Roles
{
    protected $id;
    
    protected $name;
    
    protected $addTime;
    
	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getAddTime() {
		return $this->addTime;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setAddTime($addTime) {
		$this->addTime = $addTime;
	}

}

?>