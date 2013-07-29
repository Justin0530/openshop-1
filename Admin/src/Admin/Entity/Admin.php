<?php
namespace Admin\Entity;

class Admin{
    
    protected $id;
    
    protected $name;
    
    protected $password;
    
    protected $email;
    
    protected $true_name;
    
    protected $add_time;
    
    protected $departments;
    
    protected $roles;
    
    public function __construct(){
        
    }
    
	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getTrue_name() {
		return $this->true_name;
	}

	public function getAdd_time() {
		return $this->add_time;
	}

	public function getDepartments() {
		return $this->departments;
	}

	public function getRoles() {
		return $this->roles;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setTrue_name($true_name) {
		$this->true_name = $true_name;
	}

	public function setAdd_time($add_time) {
		$this->add_time = $add_time;
	}

	public function setDepartments($departments) {
		$this->departments = $departments;
	}

	public function setRoles($roles) {
		$this->roles = $roles;
	}

}