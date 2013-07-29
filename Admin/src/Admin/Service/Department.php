<?php
namespace Admin\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZfcBase\EventManager\EventProvider;

class Department extends EventProvider implements ServiceManagerAwareInterface
{
    protected $serviceManager;
    
    protected $departmentMapper;
    
    public function fetchAlltoArray(){
        $deparments = $this->departmentMapper->fetchAll();
        $result = array();
        foreach ($deparments->toArray() as $deparment){
            $result[$deparment['id']] = $deparment['name'];
        }
        return $result;
    }
    
    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
    	$this->serviceManager = $serviceManager;
    }
    
	public function getDepartmentMapper() {
		return $this->departmentMapper;
	}

	public function setDepartmentMapper($departmentMapper) {
		$this->departmentMapper = $departmentMapper;
	}
	
	


}

?>