<?php
namespace Admin\Form;

use Admin\Form\Roles;

class RolesEdit extends Roles
{

    public function __construct (\Admin\Entity\Roles $roles){
        parent::__construct();
    	$this->setLabel("编辑角色");
    	$this->remove('name');
    	
    	$this->add(array(
    	    'name' => 'name',
    	    'options' => array(
    	        'label' => '角色名'
    	    ),
    	    'attributes' => array(
    	        'type' => 'text',
    	        'value' => $roles->getName() ?:'',
    	    ),
    	));
    	
    	$this->add(array(
    	    'name' => 'id',
    	    'attributes'=>array(
    	        'type'=>'hidden',
    	        'value'=> $roles->getId() ?:'',
    	    ),
    	));
    }
}

?>