<?php
namespace Admin\Mapper;

use Admin\Mapper\AbstractDbMapper;

class RolesMenu extends AbstractDbMapper implements MapperInterface
{
    protected $tableName = "roles_menu";
    
    protected $cache;
    
    public function findMenuByDepartment($department_id){
        $select = $this->getSelect()->where(array('department_id'=>$department_id));
        $resultSet = $this->select($select);
        return $resultSet->count() ? $resultSet : false;
    }
    
    public function findMenuByRoles($roles_id){
        //$select = new Select();
        //$select->from(array('rm'=>'roles_menu'))->join(array("m"=>"menu"), "rm.menu_id=m.id")->where(array('rm.roles_id'=>$roles_id));
    	$select = $this->getSelect()->order('id')->where(array('roles_id'=>$roles_id));
    	$resultSet = $this->select($select);
    	return $resultSet;
    }
    
    public function insert($entity, $tableName = null,\Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null){
    	parent::insert($entity);
    }
    
    public function delete($where, $tableName = null){
        parent::delete($where);
    }

	public function getCache() {
		return $this->cache;
	}

    /* (non-PHPdoc)
	 * @see \Admin\Mapper\MapperInterface::setCache()
	 */
	public function setCache(\Zend\Cache\Storage\Adapter\AbstractAdapter $cache) {
		
	    if(!$cache instanceof \Zend\Cache\Storage\Adapter\AbstractAdapter){
	        throw new \Zend\Cache\Exception\InvalidArgumentException('cache must instance of AbstractDbMapper');
	    }
		$this->cache = $cache;
	}



    
}

?>