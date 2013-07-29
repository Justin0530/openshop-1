<?php
namespace Admin\Entity;

class RolesMenu
{
    protected $id;
    
    protected $menuId;
    
    protected $rolesId;
    
    
	public function getId() {
		return $this->id;
	}

	public function getMenuId() {
		return $this->menuId;
	}

	public function getRolesId() {
		return $this->rolesId;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setMenuId($menuId) {
		$this->menuId = $menuId;
	}

	public function setRolesId($rolesId) {
		$this->rolesId = $rolesId;
	}




    
	


}

?>