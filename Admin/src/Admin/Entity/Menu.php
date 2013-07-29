<?php
namespace Admin\Entity;

class Menu{
    
    protected $id;
    
    protected $label;
    
    protected $module;
    
    protected $controller;
    
    protected $action;
    
    protected $isModule;
    
    protected $isMenu;
    
    protected $addTime;
    
	public function getId() {
		return $this->id;
	}

	public function getLabel() {
		return $this->label;
	}

	public function getModule() {
		return $this->module;
	}

	public function getController() {
		return $this->controller;
	}

	public function getAction() {
		return $this->action;
	}

	public function getIsModule() {
		return $this->isModule;
	}

	public function getIsMenu() {
		return $this->isMenu;
	}

	public function getAddTime() {
		return $this->addTime;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setLabel($label) {
		$this->label = $label;
	}

	public function setModule($module) {
		$this->module = $module;
	}

	public function setController($controller) {
		$this->controller = $controller;
	}

	public function setAction($action) {
		$this->action = $action;
	}

	public function setIsModule($isModule) {
		$this->isModule = $isModule;
	}

	public function setIsMenu($isMenu) {
		$this->isMenu = $isMenu;
	}

	public function setAddTime($addTime) {
		$this->addTime = $addTime;
	}

    

}