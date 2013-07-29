<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * DepartmentController
 *
 * @author
 *
 * @version
 *
 */
class DepartmentController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated DepartmentController::indexAction() default action
        return new ViewModel();
    }
    
    
}