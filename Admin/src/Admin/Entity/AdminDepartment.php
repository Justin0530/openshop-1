<?php
namespace Admin\Entity;

class AdminDepartment
{
    protected $id;
    
    protected $department_id;
    
    protected $department_name;
    
    protected $admin_id;
    
	public function getId() {
		return $this->id;
	}

	public function getDepartment_id() {
		return $this->department_id;
	}

	public function getDepartment_name() {
		return $this->department_name;
	}

	public function getAdmin_id() {
		return $this->admin_id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setDepartment_id($department_id) {
		$this->department_id = $department_id;
	}

	public function setDepartment_name($department_name) {
		$this->department_name = $department_name;
	}

	public function setAdmin_id($admin_id) {
		$this->admin_id = $admin_id;
	}

}

?>