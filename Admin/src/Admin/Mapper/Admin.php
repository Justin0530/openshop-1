<?php
namespace Admin\Mapper;

use Admin\Mapper\AbstractDbMapper;
use Admin\Mapper\MapperInterface;

class Admin extends AbstractDbMapper implements MapperInterface{
    
    protected $tableName = 'admin';
    
    protected $cache;
    
	
	public function findById($id){
	    $select = $this->getSelect()->where(array('id'=>$id));	    
	    $entity = $this->select($select)->current();
	    return $entity;
	}
	
	public function findByName($name){
	    $select = $this->getSelect()->where(array('name'=>$name));
	    $entity = $this->select($select)->current();
	    return $entity;
	}
	
	public function findByEmail($email){
	    $select = $this->getSelect()->where(array('email'=>$email));
	    $entity = $this->select($select)->current();
	    return $entity;
	}
	
	public function fetchAll(){
	    $select = $this->getSelect();
	    $resultSet = $this->select($select);
	    return $resultSet;
	}
	
	
	public function getDepartmentsById($id){
	    
	}
	
	public function getRolesById($id){
	    
	}
	
	public function insert($entity, $tableName = null,\Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null){
	    parent::insert($entity);
	}
	
	public function update($entity, $where, $tableName = null, \Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null){
	    parent::update($entity, $where);
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

	/* (non-PHPdoc)
	 * @see \Admin\Mapper\MapperInterface::getCache()
	 */
	public function getCache() {
		// TODO Auto-generated method stub
		return $this->cache;
	}

  
}