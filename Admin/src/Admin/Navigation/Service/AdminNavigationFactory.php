<?php
namespace Admin\Navigation\Service;

use Zend\ServiceManager\FactoryInterface;


class AdminNavigationFactory implements FactoryInterface{
    
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
		$navigation = new \Admin\Navigation\AdminNavigation();
		return $navigation->createService($serviceLocator);
	}

    
}