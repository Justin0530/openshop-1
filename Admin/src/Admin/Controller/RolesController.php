<?php
namespace Admin\Controller;

/**
 * RolesController
 *
 * @author
 *
 * @version
 *
 */
class RolesController extends AbstractController
{
    public  $menu_configs = array(
    		'module'  => array(
    				'label' => '系统管理',
    				'module'=> 'admin',
    		),
    		'menu'    => array(
    				'label' => '角色管理',
    				'module'=> 'admin',
    		        'controller'=> 'roles',
    		        'action'=>'index',
    		),
    		'actions' => array(
    				'add'  => array(
    						'label' => '角色管理-创建',
    						'module'=> 'admin',
    				),
    				'edit'  => array(
    						'label' => '角色管理-编辑',
    						'module'=> 'admin',
    				),
    				'delete'  => array(
    						'label' => '角色管理-删除',
    						'module'=> 'admin',
    				),
    		),
    
    );
    
    protected $rolesService;
    
    protected $menuService;
    
    protected $addForm;

    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $paginator = $this->getRolesService()->getList($this->getRequest()->getQuery("page"));
        return array(
            'paginator' => $paginator,
        );
    }
    
    
    public function addAction(){
        $request = $this->getRequest();
        $form = $this->getAddForm();
        $service = $this->getRolesService();
        $menu_service = $this->getMenuService();
        
        if ($request->isPost()) {
        	$roles = $this->rolesService->addRoles($request->getPost());
        	if ($roles) {
        	    $roles_menu_service = $this->getServiceLocator()->get('roles_menu_service');
        	    $data = array();
        	    $data['id'] = $roles->getGeneratedValue();
        	    $data['menu_id'] = $request->getPost('actions');
        	    $roles_menu_service->addRolesMenu($data);
        		return $this->redirect()->toUrl("/admin/roles/index");
        	}else{
        	    $this->flashmessenger()->addMessage($form->getMessages());
        	    return $this->redirect()->toUrl("/admin/roles/index");
        	}
        	
        }else{
            return array(
                'form' => $form,
                'menus' => $menu_service->fetchAlltoArray(),
            );
        }
    }
    
    public function editAction(){
        $request = $this->getRequest();
        $id = $request->getQuery("id")?:$request->getPost("id");
        $roles_service = $this->getServiceLocator()->get('roles_service');
        $roles_menu_service = $this->getServiceLocator()->get('roles_menu_service');
        $menu_service = $this->getMenuService();
        
        $roles = $roles_service->findById($id);
        $actions = $roles_menu_service->findMenuByRoles($roles->getId());
 
        $form = new \Admin\Form\RolesEdit($roles);
        $form->setInputFilter(new \Admin\Filter\RolesAddFilter(
                new \Admin\Validator\RecordExists(array(
                        'key' => 'name',
                        'mapper' => $this->getServiceLocator()->get('roles_mapper'),
                     ))
                )
            );
        
        if ($request->isPost()) {
        	$roles = $roles_service->editRoles($request->getPost());
        	if ($id) {
        		$roles_menu_service = $this->getServiceLocator()->get('roles_menu_service');
        	    $data = array();
        	    $data['id'] = $id;
        	    $data['menu_id'] = $request->getPost('actions');
        	    $roles_menu_service->editRolesMenu($data);
        	};
        	return $this->redirect()->toUrl("/admin/roles/index");
        }else{
            return array(
            		'form' => $form,
            		'menus' => $menu_service->fetchAlltoArray(),
            		'actions' => $actions
            );
        }
        
        
    }
    
    
	public function getRolesService() {
		if(!$this->rolesService){
		    $this->rolesService = $this->getServiceLocator()->get('roles_service');
		}
		
		return $this->rolesService;
	}

	public function getAddForm() {
	    if(!$this->addForm){
	    	$this->addForm = $this->getServiceLocator()->get('roles_add_form');
	    }
		return $this->addForm;
	}

	public function setRolesService($rolesService) {
		$this->rolesService = $rolesService;
	}

	public function setAddForm($addForm) {
		$this->addForm = $addForm;
	}
	public function getMenuService() {
	    if(!$this->menuService){
	    	$this->menuService = $this->getServiceLocator()->get('menu_service');
	    }
		return $this->menuService;
	}

	public function setMenuService($menuService) {
		$this->menuService = $menuService;
	}


}