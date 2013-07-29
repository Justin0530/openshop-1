<?php
namespace Admin\Entity;

class DepartmentRoles
{
    protected $id;
    
    protected $departmentId;
    
    protected $rolesId;
    
    protected $rolesName;
    
	public function getId() {
		return $this->id;
	}

	public function getDepartmentId() {
		return $this->departmentId;
	}



	public function setId($id) {
		$this->id = $id;
	}

	public function setDepartmentId($departmentId) {
		$this->departmentId = $departmentId;
	}
	
	public function getRolesId() {
		return $this->rolesId;
	}

	public function getRolesName() {
		return $this->rolesName;
	}

	public function setRolesId($rolesId) {
		$this->rolesId = $rolesId;
	}

	public function setRolesName($rolesName) {
		$this->rolesName = $rolesName;
	}




}

?>