<?php
namespace Admin\src\Admin\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZfcBase\EventManager\EventProvider;

class AdminDepartment extends EventProvider implements ServiceManagerAwareInterface
{
    protected $serviceManager;
    
    protected $adminDepartmentMapper;
    
    public function getAllDepartments(){
        
    }
    
	public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
		$this->serviceManager = $serviceManager;
	}
	public function getAdminDepartmentMapper() {
		return $this->adminDepartmentMapper;
	}

	public function setAdminDepartmentMapper($adminDepartmentMapper) {
		$this->adminDepartmentMapper = $adminDepartmentMapper;
	}


}

?>