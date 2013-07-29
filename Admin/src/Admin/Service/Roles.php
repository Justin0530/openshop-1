<?php
namespace Admin\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZfcBase\EventManager\EventProvider;

class Roles extends EventProvider implements ServiceManagerAwareInterface
{
    protected $serviceManager;
    
    protected $rolesMapper;
    
    public function fetchAlltoArray(){
        $deparments = $this->departmentMapper->fetchAll();
        $result = array();
        foreach ($deparments->toArray() as $deparment){
            $result[$deparment['id']] = $deparment['name'];
        }
        return $result;
    }
    
    public function getList($pageNumber){
        $roles = $this->rolesMapper->fetchAll();
        $roles = $roles->toArray();
        $data = array();
        $roles_menu_mapper = $this->serviceManager->get('roles_menu_mapper');
        $menu_mapper = $this->serviceManager->get('menu_mapper');
        foreach ($roles as $v){
            $menus = $roles_menu_mapper->findMenuByRoles($v['id'])->toArray();
            $temp = array();
            foreach ($menus as $menu){
                $menu['label'] = $menu_mapper->getLabelByMenuId($menu['menu_id'])->getLabel();
                $temp[] = $menu;
            }
            $v['menus'] = $temp;
            $data[] = $v;
        }
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($data));
        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setDefaultItemCountPerPage(15);
        return $paginator;
    }
    
    public function addRoles($data){
        $roles = new \Admin\Entity\Roles();
        $form = $this->serviceManager->get('roles_add_form');
        $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        $form->bind($roles);
        $form->setData($data);
        
        if (!$form->isValid()) {
        	return false;
        }
        
        $roles = $form->getData();
        $roles->setAddTime(time());
        return $this->rolesMapper->insert($roles);
    }
    
    public function editRoles($data){
        $roles = new \Admin\Entity\Roles();
        $form = new \Admin\Form\RolesEdit($roles);
        $form->setInputFilter(new \Admin\Filter\RolesAddFilter(
        		new \Admin\Validator\RecordExists(array(
        				'key' => 'name',
        				'mapper' => $this->serviceManager->get('roles_mapper'),
        		))
        )
        );
        $form->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        $form->bind($roles);
        $form->setData($data);
        
        if (!$form->isValid()) {
        	return false;
        }
        
        $roles = $form->getData();
        $roles->setAddTime(time());
        return $this->rolesMapper->update($roles);
    }
    
    
    public function findById($id){
        return  $this->rolesMapper->findById($id);
    }
    
    public function setServiceManager(\Zend\ServiceManager\ServiceManager $serviceManager) {
    	$this->serviceManager = $serviceManager;
    }
    
	public function getRolesMapper() {
		return $this->rolesMapper;
	}

	public function setRolesMapper($rolesMapper) {
		$this->rolesMapper = $rolesMapper;
	}

    
	
	


}

?>