<?php
namespace Admin\Mapper;

use ZfcBase\Mapper\AbstractDbMapper as BaseAbstractDbMapper;

class AbstractDbMapper extends BaseAbstractDbMapper{
    
    /**
     * @param object|array $entity
     * @param string|TableIdentifier|null $tableName
     * @param HydratorInterface|null $hydrator
     * @return ResultInterface
     */
	protected function insert($entity, $tableName = null,\Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null) {
	    $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setId($result->getGeneratedValue());
        return $result;
	}
	
	
	/**
	 * @param object|array $entity
	 * @param string|array|closure $where
	 * @param string|TableIdentifier|null $tableName
	 * @param HydratorInterface|null $hydrator
	 * @return ResultInterface
	 */
	protected function update($entity, $where, $tableName = null, \Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null)
	{
		 if (!$where) {
            $where = 'id = ' . $entity->getId();
        }

        return parent::update($entity, $where, $tableName, $hydrator);
	}
	

    
}