<?php
namespace Admin\Navigation;

use Zend\Navigation\Service\DefaultNavigationFactory;

class AdminNavigation extends DefaultNavigationFactory{
    
    
    
	protected function getPages(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
	    
	    $navigation = array();
	    
		if (null === $this->pages) {

            $application = $serviceLocator->get('Application');
            $routeMatch  = $application->getMvcEvent()->getRouteMatch();
            $router      = $application->getMvcEvent()->getRouter();
            
            $mapper = $serviceLocator->get('menu_mapper');
            $parents = $mapper->getParents();
            if($parents){
                foreach ($parents as $parent){
                    $childs = $mapper->getChildByModule($parent->getModule());
                    if ($childs) {
                        $child_pages = array();
                    	foreach ($childs as $child){
                    	    $child_pages[] = array(
                    	        'label'      => $child->getLabel(),
                    	        'controller' => $child->getController(),
                    	        'action'     => $child->getAction(),
                    	    );
                    	}
                    }
                    $navigation[] = array(
                        'label' => $parent->getLabel(),
                        'controller' => $parent->getController(),
                        'action'     => $parent->getAction(),
                        'pages' =>  $child_pages
                    );
                }
            }
            $pages       = $this->getPagesFromConfig($navigation);

            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }
        return $this->pages;
		
	}

}