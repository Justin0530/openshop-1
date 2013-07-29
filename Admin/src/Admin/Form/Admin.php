<?php
namespace Admin\Form;

use ZfcBase\Form\ProvidesEventsForm;


class Admin extends ProvidesEventsForm {
    
    protected $departmentService;
    
    
    public function __construct($departmentService){
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->setLabel("添加管理员");
        $this->setDepartmentService($departmentService);
        $this->addElements();
    }
    
    protected function addElements(){
        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => '登陆名'
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));
        
        $this->add(array(
    		'name' => 'password',
    		'options' => array(
				'label' => '密码'
    		),
    		'attributes' => array(
				'type' => 'hidden'
    		),
        ));
        
        $this->add(array(
    		'name' => 'email',
    		'options' => array(
				'label' => '邮箱'
    		),
    		'attributes' => array(
				'type' => 'Zend\Form\Element\Email'
    		),
        ));
        
        $this->add(array(
    		'name' => 'true_name',
    		'options' => array(
				'label' => '真名'
    		),
    		'attributes' => array(
				'type' => 'text'
    		),
        ));
        
        $this->add(array(
        		'type' => '\Zend\Form\Element\Select',
        		'name' => 'departments',
        
        		'options' => array(
        				'label' => '所在部门',
        				'label_attributes' => array(
        						"class" => 'checkbox inline',
        				),
        				'value_options' => $this->getDepartmentService()->fetchAlltoArray()
        		),
                'attributes' => array(
                    'id' => 'department_id'
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

	public function getDepartmentService() {
		return $this->departmentService;
	}

	public function setDepartmentService($departmentService) {
		$this->departmentService = $departmentService;
	}



    
}