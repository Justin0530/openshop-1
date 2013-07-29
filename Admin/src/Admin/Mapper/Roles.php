<?php
namespace Admin\Mapper;

use Admin\Mapper\AbstractDbMapper;
use Admin\Mapper\MapperInterface;
class Roles extends AbstractDbMapper implements MapperInterface
{
    protected $tableName = 'roles';
    
    protected $cache;
    
    public function fetchAll(){
        $select = $this->getSelect()->columns(array('id','name'))->order('id');
        $resultSet = $this->select($select);
        
        return $resultSet;
    }
    
    public function findByName($name){
    	$select = $this->getSelect()->where(array('name'=>$name));
    	$entity = $this->select($select)->current();
    	return $entity;
    }
    
    public function findById($id){
        $select = $this->getSelect()->where(array('id'=>$id));
        $entity = $this->select($select)->current();
        return $entity;
    }
    
    public function insert($entity, $tableName = null,\Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null){
    	return parent::insert($entity);
    }
    

	public function setCache(\Zend\Cache\Storage\Adapter\AbstractAdapter $cache) {
    
    	if(!$cache instanceof \Zend\Cache\Storage\Adapter\AbstractAdapter){
    		throw new \Zend\Cache\Exception\InvalidArgumentException('cache must instance of AbstractDbMapper');
    	}
    	$this->cache = $cache;
    }
    
    public function update($entity, $where = null, $tableName = null, \Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null)
    {
    	if (!$where) {
    		$where = 'id = ' . $entity->getId();
    	}
    
    	return parent::update($entity, $where, $tableName, $hydrator);
    }
    
    /* (non-PHPdoc)
     * @see \Admin\Mapper\MapperInterface::getCache()
    */
    public function getCache() {
    	// TODO Auto-generated method stub
    	return $this->cache;
    }
    
}

?>