<?php
namespace Admin\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZfcBase\EventManager\EventProvider;

class Menu extends EventProvider implements ServiceManagerAwareInterface
{
    protected $serviceManager;
    
    protected $menuMapper;
    
    public function fetchAlltoArray(){
        $menus = $this->menuMapper->getParents();
        $result = array();
        foreach ($menus->toArray() as $key => $menu){
            $childs = $this->menuMapper->getChildByModule($menu['module'],0);
            $result[$key]['childs'] = $childs->toArray();
            $result[$key]['id'] = $menu['id'];
            $result[$key]['label'] = $menu['label'];
        }
        return $result;
    }
    
    public function getLabelByMenuId(){
        return $this->menuMapper->getLabelByMenuId()->toArray();
    }
    
    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
    	$this->serviceManager = $serviceManager;
    }
    
	public function getMenuMapper() {
		return $this->menuMapper;
	}

	public function setMenuMapper($menuMapper) {
		$this->menuMapper = $menuMapper;
	}

    


}

?>