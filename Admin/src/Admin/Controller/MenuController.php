<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;

/**
 * MenuController
 *
 * @author
 *
 * @version
 *
 */
class MenuController extends AbstractController
{
    public  $menu_configs = array(
                'module'  => array(
                            'label' => '系统管理',
                            'module'=> 'Admin',
                            ),
        		'menu'    => array(
                            'label' => '菜单管理',
                            'module'=> 'Admin',
                            ),
                'actions' => array(
                    'index'   => array(
                            'label' => 'list',
                            'module'=> 'Admin',
                            ),
                    'create'  => array(
                            'label' => 'add',
                            'module'=> 'Admin',
                            ),
                    'update'  => array(
                            'label' => 'edit',
                            'module'=> 'Admin',
                            ),
                    'delete'  => array(
                            'label' => 'del',
                            'module'=> 'Admin',
                            ),
                ),
        
        );

    public function indexAction ()
    {
        return new ViewModel();
    }
}