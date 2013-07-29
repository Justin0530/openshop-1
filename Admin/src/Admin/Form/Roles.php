<?php
namespace Admin\Form;

use ZfcBase\Form\ProvidesEventsForm;


class Roles extends ProvidesEventsForm {
    
    public function __construct(){
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->setLabel("添加角色");
        $this->addElements();
    }
    
    protected function addElements(){
        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => '角色名'
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        
        $this->add(new \Zend\Form\Element\Csrf('security'));
        
        $this->add(array(
    		'name' => 'save',
    		'options' => array(
				'label' => '保存'
    		),
    		'attributes' => array(
				'type' => 'submit',
    		    'value' => '保存'
    		),
        ));
        
    }

    
}