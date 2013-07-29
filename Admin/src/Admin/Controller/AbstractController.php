<?php
namespace Admin\Controller;
use Zend\Mvc\Controller\AbstractActionController;

class AbstractController extends AbstractActionController
{
    /**
     * 
     * @var \Zend\Mvc\Router\RouteMatch
     */
    protected $routeMatch;
    
    protected $mapper;

	/* (non-PHPdoc)
	 * @see \Admin\Controller\ControllerInfterface::registerCtrl()
	 */
	public function registerCtrl($menus,\Admin\Mapper\Menu $menu_mapper) {
	    
	    if(null === $menus || !is_array($menus)){
	    	throw new \Exception('menus is array and not empty.');
	    }
	    
	    if(null === $this->getMyRouteMatch()){
	        throw new \Exception('must set property routerMatch.');
	    }
	    
	    $this->mapper = $menu_mapper;
	    
	    //通过路由匹配查询moudle controller action 
	    //$module = $this->routeMatch->getMatchedRouteName();
	    $controller = $this->routeMatch->getParam('controller');
	    $action = $this->routeMatch->getParam('action');
	    $controllers = explode('\\',$controller);
	    $controller = array_pop($controllers);
	    
	    if(array_key_exists('module', $menus) && !$this->moduleIsExists($menus['module'])){
	        $entity = new \Admin\Entity\Menu();
	        $entity->setLabel($menus['module']['label']);
	        $entity->setModule($menus['module']['module']);
	        $entity->setController($controller);
	        $entity->setAction("#");
	        $entity->setAddTime(time());
	        $entity->setIsModule(1);
	        $entity->setIsMenu(1);
	        $this->mapper->insert($entity);
	    }
	    if(array_key_exists('menu', $menus)){
	        $menu = $menus['menu'];
	        if(!$this->menuIsExists($menu)){
	        	$entity = new \Admin\Entity\Menu();
	        	$entity->setLabel($menu['label']);
	        	$entity->setModule($menu['module']);
	        	$entity->setController($menu['controller']);
	        	$entity->setAction($menu['action']);
	        	$entity->setAddTime(time());
	        	$entity->setIsModule(0);
	        	$entity->setIsMenu(1);
	        	$this->mapper->insert($entity);	        	
	        }
	        unset($menu);
	    }
	 
	    if(array_key_exists('actions', $menus)){
        	foreach ($menus["actions"] as $k=>$vv){
        		$actionarr['label'] = $vv['label'];
        		$actionarr['module'] = $vv['module'];
        		$actionarr['controller'] = $controller;
        		$actionarr["action"] = $k;
        
        		if (!$this->actionIsExists($actionarr)) {
        			$entity = new \Admin\Entity\Menu();
        			$entity->setLabel($actionarr['label']);
        			$entity->setModule($actionarr['module']);
        			$entity->setController($controller);
        			$entity->setAction($actionarr["action"]);
        			$entity->setAddTime(time());
        			$entity->setIsModule(0);
        			$entity->setIsMenu(0);
        			$this->mapper->insert($entity);        			
        		}
        		unset($actionarr);
        	}
	        
	    }

	}
	

	public function setMyRouteMatch(\Zend\Mvc\Router\RouteMatch $routeMatch)
	{
	    $this->routeMatch = $routeMatch;
	}
	
	public function getMyRouteMatch() {
		return $this->routeMatch;
	}
	
	
	
	public function moduleIsExists($module){
	    if (!is_array($module) || !array_key_exists('label', $module)) {
	    	throw new \Exception('module is array and has key label/module.');
	    }
	    
	    $where = array(
	      'label'    =>  trim($module['label']),
	      'module'   =>  trim($module['module']),
	      'is_module'=>  1
	    );
	    return $this->mapper->isExists($where);
	}
	
	public function menuIsExists($menu){
		if (!is_array($menu) || !array_key_exists('label', $menu)) {
			throw new \Exception('menu is array and has key label/menu.');
		}
		 
		$where = array(
				'label'    =>  trim($menu['label']),
				'module'   =>  trim($menu['module']),
		        'controller' => trim($menu['controller']),
		        'action' => trim($menu['action']),
				//'is_module'=>  0,
		        //'is_menu'  =>  1,
		);
		return $this->mapper->isExists($where);
	}

	public function actionIsExists($action){
		if (!is_array($action)) {
			throw new \Exception('menu is array.');
		}
			
		$where = array(
				'label'    =>  trim($action['label']),
				'module'   =>  trim($action['module']),
				'controller' => trim($action['controller']),
				'action' => trim($action['action']),
				'is_module'=>  0,
				'is_menu'  =>  0,
		);
		return $this->mapper->isExists($where);
	}
	
	public function setLayout($template = 'admin/layout'){
	    $this->layout($template);
	}

    
}

?>