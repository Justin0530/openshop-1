<?php
namespace Admin\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZfcBase\EventManager\EventProvider;

class RolesMenu extends EventProvider implements ServiceManagerAwareInterface
{
    protected $mapper;

    protected $serviceManager;
    
    public function addRolesMenu($data){
        
        for ($i=0;$i<count($data['menu_id']);$i++){
            $roles_menu = new \Admin\Entity\RolesMenu();
            $roles_menu->setRolesId($data['id']);
            $roles_menu->setMenuId($data['menu_id'][$i]);
            $this->mapper->insert($roles_menu);
        }
    }
    
    public function editRolesMenu($data){
        $t_data = $data;
        $new_menusId = array_pop($t_data);
        $indb_menus = $this->mapper->findMenuByRoles($data['id']);
        if ($indb_menus->count()) {
            $indb_menusId = array();
        	foreach ($indb_menus as $m){
        	    $indb_menusId[] = $m->getMenuId();
        	}
        	$this->mapper->delete("roles_id=".$data['id']);
        	if (!empty($new_menusId)) {
        		$new = $indb_menusId + $new_menusId;
            	$add_data['id'] = $data['id'];
            	$add_data['menu_id'] = $new;
            	var_dump($add_data);
            	$this->addRolesMenu($add_data);
        	}
        	
        }else{
            $this->addRolesMenu($data);
        }
    }
    public function findMenuByRoles($roles_id){
        $roles_menu = $this->mapper->findMenuByRoles($roles_id);
        $return = array();
        foreach ($roles_menu->toArray() as $v){
            $return[] = $v['menu_id'];
        }
        return $return;
    }    
	public function getMapper() {
		return $this->mapper;
	}

	public function getServiceManager() {
		return $this->serviceManager;
	}

	public function setMapper($mapper) {
		$this->mapper = $mapper;
	}
	
	public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
		$this->serviceManager = $serviceManager;
	}



    
    
}

?>