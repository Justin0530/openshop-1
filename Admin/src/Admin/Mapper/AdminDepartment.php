<?php
namespace Admin\Mapper;

use Admin\Mapper\AbstractDbMapper;

class AdminDepartment extends AbstractDbMapper implements MapperInterface
{
    protected $tablename = 'admin_department';
    
    protected $cache;
    
	public function getCache() {
		// TODO Auto-generated method stub
		
	}

	public function setCache(\Zend\Cache\Storage\Adapter\AbstractAdapter $cache) {
		// TODO Auto-generated method stub
		
	}
	
	public function findDepartmentByAdminId($admin_id){
	    $select = $this->getSelect()->where(array('admin_id'=>$admin_id));
	    $resultSet = $this->select($select);
	    
	    return $resultSet;
	}
	
	public function fetchAll(){
	    
	}

    
}

?>