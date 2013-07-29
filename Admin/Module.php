<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Admin\Entity\Admin;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Admin\Entity\Menu;
use Admin\Entity\Department;
use Admin\Entity\Roles;
use Admin\Entity\RolesMenu;

class Module implements AutoloaderProviderInterface,
                        ServiceProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $serviceManager = $e->getApplication()->getServiceManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        //初始化session
        $this->bootstrapSession($e);  
        //初始化controller
        $controllerLoader = $serviceManager->get('ControllerLoader');
        $menu_mapper = $serviceManager->get('menu_mapper');
        $controllerLoader->addInitializer(function ($controller) use ($serviceManager,$menu_mapper) { 
            $event = $serviceManager->get('Application')->getMvcEvent();            
            $routeMatch = $event->getRouteMatch();
            
            $controller_str = $routeMatch->getParam('controller');
            if (false !== strpos($controller_str, __NAMESPACE__)) {
           	    $viewModel = $event->getViewModel();
                $viewModel->setTemplate('admin/layout');
            }
            
            if(method_exists($controller, 'setMyRouteMatch')){
                $controller->setMyRouteMatch($routeMatch);
                if(!empty($controller->menu_configs) && is_array($controller->menu_configs)){
                	$controller->registerCtrl($controller->menu_configs,$menu_mapper);
                }else {
                    throw new \Exception("Not found mens_configs property in controller.");
                }
            }

        });
    }

    
    public function bootstrapSession($e){
        $session = $e->getApplication()->getServiceManager()->get('Zend\Session\SessionManager');
        $session->start();
        
        $container = new \Zend\Session\Container();
        if (!isset($container->init)) {
        	$session->regenerateId(true);
        	$container->init = 1;
        }
    }
    
	/* (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\ServiceProviderInterface::getServiceConfig()
	 */
	public function getServiceConfig() {
		return array(
		    'factories' => array(
		        'navigation' => '\Admin\Navigation\Service\AdminNavigationFactory',
		        'admin_mapper' => function ($sm){
		          $db_adapter = $sm->get('MasterSlaveAdapter');
		          $cache = $sm->get('cacheAdapter');
		          $admin_mapper = new \Admin\Mapper\Admin();
		          $admin_mapper->setDbAdapter($db_adapter);
		          $admin_mapper->setDbSlaveAdapter($db_adapter->getSlaveAdapter());
		          $admin_mapper->setCache($cache);
		          $admin_mapper->setEntityPrototype(new Admin());
		          return $admin_mapper;
		        },
		        'admin_service' => function ($sm){
		            $admin_mapper = $sm->get('admin_mapper');
		            $admin_service = new \Admin\Service\Admin();
		            $admin_service->setAdminMapper($admin_mapper);
		            $admin_service->setServiceManager($sm);
		            $admin_form = $sm->get('admin_form');
		            $admin_service->setAdmin_form($admin_form);
		            return $admin_service;
		        },
		        'admin_add_form' => function ($sm){
		            $admin_mapper = $sm->get('admin_mapper');
		            $department_service = $sm->get('department_service');
		            $admin_form = new \Admin\Form\Admin($department_service);
		            $admin_form->setInputFilter(new \Admin\Filter\AdminAddFilter(
    		                new \Admin\Validator\RecordExists(array(
    		                		'key' => 'email',
    		                		'mapper' => $admin_mapper,
    		                )),new \Admin\Validator\RecordExists(array(
    		                		'key' => 'name',
    		                		'mapper' => $admin_mapper,
    		                ))
		                )
		            );
		            return $admin_form;
		        },
		        'Zend\Session\SessionManager' => function ($sm) {
		        	$config = $sm->get('config');
		        	if (isset($config['session'])) {
		        		$session = $config['session'];
		        
		        		$sessionConfig = null;
		        		if (isset($session['config'])) {
		        			$class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
		        			$options = isset($session['config']['options']) ? $session['config']['options'] : array();
		        			$sessionConfig = new $class();
		        			$sessionConfig->setOptions($options);
		        		}
		        
		        		$sessionStorage = null;
		        		if (isset($session['storage'])) {
		        			$class = $session['storage'];
		        			$sessionStorage = new $class();
		        		}
		        
		        		$sessionSaveHandler = null;
		        		if (isset($session['save_handler'])) {
		        			// class should be fetched from service manager since it will require constructor arguments
		        			$sessionSaveHandler = $sm->get($session['save_handler']);
		        		}
		        
		        		$sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
		        
		        		if (isset($session['validators'])) {
		        			$chain = $sessionManager->getValidatorChain();
		        			foreach ($session['validators'] as $validator) {
		        				$validator = new $validator();
		        				$chain->attach('session.validate', array($validator, 'isValid'));
		        
		        			}
		        		}
		        	} else {
		        		$sessionManager = new SessionManager();
		        	}
		        	Container::setDefaultManager($sessionManager);
		        	return $sessionManager;
		        },
		        'menu_mapper' => function ($sm){
		        	$db_adapter = $sm->get('MasterSlaveAdapter');
		        	$cache = $sm->get('cacheAdapter');
		        	$menu_mapper = new \Admin\Mapper\Menu();
		        	$menu_mapper->setDbAdapter($db_adapter);
		        	$menu_mapper->setDbSlaveAdapter($db_adapter->getSlaveAdapter());
		        	$menu_mapper->setCache($cache);
		        	$menu_mapper->setEntityPrototype(new Menu());
		        	return $menu_mapper;
		        },
		        'menu_service' => function ($sm){
		        	$menu_mapper = $sm->get('menu_mapper');
		        	$menu_service = new \Admin\Service\Menu();
		        	$menu_service->setMenuMapper($menu_mapper);
		        	$menu_service->setServiceManager($sm);
		        	return $menu_service;
		        },
		        'department_mapper' => function ($sm){
		        	$db_adapter = $sm->get('MasterSlaveAdapter');
		        	$cache = $sm->get('cacheAdapter');
		        	$department_mapper = new \Admin\Mapper\Department();
		        	$department_mapper->setDbAdapter($db_adapter);
		        	$department_mapper->setDbSlaveAdapter($db_adapter->getSlaveAdapter());
		        	$department_mapper->setCache($cache);
		        	$department_mapper->setEntityPrototype(new Department());
		        	return $department_mapper;
		        },
		        'department_service' => function ($sm){
		        	$department_mapper = $sm->get('department_mapper');
		        	$department_service = new \Admin\Service\Department();
		        	$department_service->setDepartmentMapper($department_mapper);
		        	$department_service->setServiceManager($sm);
		        	return $department_service;
		        },
		        'roles_add_form' => function ($sm){
		        	$roles_mapper = $sm->get('roles_mapper');
		        	$roles_form = new \Admin\Form\Roles();
		        	$roles_form->setInputFilter(new \Admin\Filter\RolesAddFilter(
		        	    new \Admin\Validator\RecordExists(array(
		        	    		'key' => 'name',
		        	    		'mapper' => $roles_mapper,
		        	    ))
		        	)
		        	);
		        	return $roles_form;
		        },
		        'roles_mapper' => function ($sm){
		        	$db_adapter = $sm->get('MasterSlaveAdapter');
		        	$cache = $sm->get('cacheAdapter');
		        	$roles_mapper = new \Admin\Mapper\Roles();
		        	$roles_mapper->setDbAdapter($db_adapter);
		        	$roles_mapper->setDbSlaveAdapter($db_adapter->getSlaveAdapter());
		        	$roles_mapper->setCache($cache);
		        	$roles_mapper->setEntityPrototype(new Roles());
		        	return $roles_mapper;
		        },
		        'roles_service' => function ($sm){
		        	$roles_mapper = $sm->get('roles_mapper');
		        	$roles_service = new \Admin\Service\Roles();
		        	$roles_service->setRolesMapper($roles_mapper);
		        	$roles_service->setServiceManager($sm);
		        	return $roles_service;
		        },
		        'roles_menu_mapper' => function ($sm){
		        	$db_adapter = $sm->get('MasterSlaveAdapter');
		        	$cache = $sm->get('cacheAdapter');
		        	$roles_menu_mapper = new \Admin\Mapper\RolesMenu();
		        	$roles_menu_mapper->setDbAdapter($db_adapter);
		        	$roles_menu_mapper->setDbSlaveAdapter($db_adapter->getSlaveAdapter());
		        	$roles_menu_mapper->setCache($cache);
		        	$roles_menu_mapper->setEntityPrototype(new RolesMenu());
		        	return $roles_menu_mapper;
		        },
		        'roles_menu_service' => function ($sm){
		        	$roles_menu_mapper = $sm->get('roles_menu_mapper');
		        	$roles_menu_service = new \Admin\Service\RolesMenu();
		        	$roles_menu_service->setMapper($roles_menu_mapper);
		        	$roles_menu_service->setServiceManager($sm);
		        	return $roles_menu_service;
		        },
		    ),
		);
		
	}

}
