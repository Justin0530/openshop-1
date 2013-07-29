<?php
namespace Admin\Controller;

use Admin\Controller\AbstractController;
use Zend\View\Model\ViewModel;


class AdminController extends AbstractController
{
    public  $menu_configs = array(
    		'module'  => array(
    				'label' => '系统管理',
    				'module'=> 'admin',
    		),
    		'menu'    => array(
    				'label' => '用户管理',
    				'module'=> 'admin',
        		    'controller'=> 'admin',
        		    'action'=>'index',
    		),
    		'actions' => array(
    				'add'  => array(
    						'label' => '用户管理-创建',
    						'module'=> 'admin',
    				),
    				'edit'  => array(
    						'label' => '用户管理-编辑',
    						'module'=> 'admin',
    				),
    				'delete'  => array(
    						'label' => '用户管理-删除',
    						'module'=> 'admin',
    				),
    		),
    
    );
    
    public $adminService;
    
    public $addForm;
    
    public function indexAction(){
        return array(
            'a' => 1,
        );
    }
    
    public function addAction(){
        $request= $this->getRequest();
        $service = $this->getAdminService();
        $form = $this->getAddForm();
        
        if ($request->getQuery()->get('redirect')) {
        	$redirect = $this->getQuery()->get('redirect');
        }else{
            $redirect = false;
        }
        $redirectUrl = $this->url()->fromRoute('admin'). ($redirect ? '?redirect=' . $redirect : '');
        $prg = $this->prg($redirectUrl,true);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
        	return $prg;
        }elseif ($prg === false){
            return array(
                'add_form' => $form,
                'redirect' => $redirect
            );
        }
    }
    
    public function AjaxAction(){
        $department_menu_service = $this->getServiceLocator()->get('department_menu_service');
        $request = $this->getRequest();
        $department_id = $request->getQuery('department_id');
        $menus = $department_menu_service->findMenuByDepartment($department_id);
       
        $render = new \Zend\View\Renderer\PhpRenderer();
        $resolver = new \Zend\View\Resolver\AggregateResolver();
        
        $map = new \Zend\View\Resolver\TemplateMapResolver(array(
            'page'=> __DIR__ . '/../../../view/admin/department_menu/ajax.phtml',
        ));
        
        $resolver->attach($map);
        $render->setResolver($resolver);
        
        $vm = new ViewModel();
        $vm->setTemplate('page');
        if($menus){
            $vm->setVariable('menus', $menus);
        }
        
        $pageHtml = $render->render($vm);
        
        $response = $this->getResponse();
        $response->setContent(json_encode(array(
            'pageHtml'=> $pageHtml
        )));
        
        return $response;
    }
    
	public function getAdminService() {
		return $this->adminService;
	}

	public function setAdminService($adminService) {
		$this->adminService = $adminService;
	}
	public function getAddForm() {
		if (!$this->addForm) {
			$this->setAddForm($this->getServiceLocator()->get('admin_add_form'));
		}
		return $this->addForm;
	}

	public function setAddForm($addForm) {
		$this->addForm = $addForm;
	}


}

?>