<?php
namespace Admin\Mapper;

use Admin\Mapper\AbstractDbMapper;
use Admin\Mapper\MapperInterface;
class Department extends AbstractDbMapper implements MapperInterface
{
    protected $tablename = 'department';
    
    protected $cache;
    
    public function fetchAll(){
        $select = $this->getSelect()->columns(array('id','name'))->order('id');
        $resultSet = $this->select($select);
        
        return $resultSet;
    }
    
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
    
    public function getTablename() {
    	return $this->tablename;
    }
    
    public function setTablename($tablename) {
    	$this->tablename = $tablename;
    }
}

?>