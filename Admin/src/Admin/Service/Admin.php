<?php
namespace Admin\Service;

use ZfcBase\EventManager\EventProvider;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class Admin extends EventProvider implements ServiceManagerAwareInterface{
    
    protected $adminMapper;
    
    protected $serviceManager;
    
    protected $addForm;
    
    public function add(array $data){
        $admin = new \Admin\Entity\Admin();
        $form = $this->getAddForm();
        $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        $form->bind($admin);
        $form->setData($data);
        if(!$form->isValid()){
            return false;
        }
        
        $admin = $form->getData();
        
        $bcrypt = new \Zend\Crypt\Password\Bcrypt();
        $bcrypt->setCost(15);
        $admin->setPassword($bcrypt->create($admin->getPassword()));
        
        $this->getAdminMapper()->insert($admin);
        
    }

	public function getAdminMapper() {
		return $this->adminMapper;
	}

	public function getServiceManager() {
		return $this->serviceManager;
	}

	public function setAdminMapper($adminMapper) {
		$this->adminMapper = $adminMapper;
	}

	public function setServiceManager($serviceManager) {
		$this->serviceManager = $serviceManager;
	}

	public function getAddForm() {
		return $this->addForm;
	}

	public function setAddForm($addForm) {
		$this->addForm = $addForm;
	}



    
    
}