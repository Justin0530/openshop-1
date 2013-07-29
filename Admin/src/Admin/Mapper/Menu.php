<?php
namespace Admin\Mapper;

use Admin\Mapper\AbstractDbMapper;

class Menu extends AbstractDbMapper implements MapperInterface{
    
    protected $cache;
    
    protected $tableName = 'menu';
    
    public function getChildByModule($module,$is_menu = 1){
        $select = $this->getSelect();
        if ($is_menu) {
        	$where = array('module'=>$module,'is_module'=>0,'is_menu'=>$is_menu);
        }else{
            $where = array('module'=>$module,'is_module'=>0);
        }
        $select->where($where);
        try {
            $resultSet = $this->select($select);
        }catch (\Exception $e){
            die($e->getMessage());
        }
        return $resultSet;
    }
    
    public function getParents(){
        $select = $this->getSelect();
        $select->where(array('is_module'=>1));
        $resultSet = $this->select($select);
        return $resultSet;
    }
    
    public function fetchAll(){
        $select = $this->getSelect();
        $resultSet = $this->select($select);
        return $resultSet;
    }
    
    public function isExists($where){
        $select = $this->getSelect();
        $select = $select->where($where);
        $resultSet = $this->select($select);
        //echo @$select->getSqlString(new \Zend\Db\Adapter\Platform\Mysql());
        return ($resultSet->count() > 0) ? true : false;
    }
    
    public function getLabelByMenuId($menu_id){
        $select = $this->getSelect();
        $select->where(array('id'=>$menu_id));
        $resultSet = $this->select($select);
        return $resultSet->count() ? $resultSet->current() : false;
    }
    
    public function insert($entity, $tableName = null,\Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null){
    	parent::insert($entity, $tableName, $hydrator);
    }
    
    public function update($entity, $where, $tableName = null, \Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null){
    	parent::update($entity, $where ,$tableName, $hydrator);
    }
    
    public function getTableName() {
    	return $this->tableName;
    }
    
    public function setTableName($tableName) {
    	$this->tableName = $tableName;
    }
    
	public function getCache() {
		return $this->cache;
	}

	public function setCache(\Zend\Cache\Storage\Adapter\AbstractAdapter $cache) {
	    
	    if(!$cache instanceof \Zend\Cache\Storage\Adapter\AbstractAdapter){
	    	throw new \Zend\Cache\Exception\InvalidArgumentException('cache must instance of AbstractDbMapper');
	    }
	    $this->cache = $cache;
		
	}

    
}