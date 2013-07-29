<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Menu' => 'Admin\Controller\MenuController',
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
            'Admin\Controller\Department' => 'Admin\Controller\DepartmentController',
            'Admin\Controller\Roles' => 'Admin\Controller\RolesController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/admin[/:controller[/:action]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),

            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Admin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
		    'admin/layout' => __DIR__ . '/../view/layout/layout.phtml',
        ),
    ),
    'email' => array(
    		"template_path_stack" => array(
    				__DIR__ . "/../view/email/"
    		),
    ),
);
