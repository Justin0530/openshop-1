<?php
namespace Admin\Mapper;

use Zend\Cache\Storage\Adapter\AbstractAdapter as CacheAdapter;

interface MapperInterface
{
    public function setCache(CacheAdapter $cache);
    
    public function getCache();
}

?>