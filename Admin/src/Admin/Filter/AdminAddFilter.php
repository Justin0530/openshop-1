<?php
namespace Admin\Filter;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;

class AdminAddFilter extends ProvidesEventsInputFilter
{
    protected $emailValidator;
    
    protected $nameValidator;
    
    public function __construct($emailValidator,$nameValidator){
        $this->emailValidator = $emailValidator;
        $this->nameValidator = $nameValidator;
        
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => '3',
                        'max' => '16',
                    ),
                ),
                $this->getNameValidator(),
            ),
        ));
        
        $this->add(array(
    		'name'       => 'email',
    		'required'   => true,
    		'validators' => array(
    				array(
    					'name' => 'EmailAddress'
    				),
    				$this->emailValidator
    		),
        ));
    }
    
	public function getNameValidator() {
		return $this->nameValidator;
	}

	public function setNameValidator($nameValidator) {
		$this->nameValidator = $nameValidator;
	}
	public function getEmailValidator() {
		return $this->emailValidator;
	}

	public function setEmailValidator($emailValidator) {
		$this->emailValidator = $emailValidator;
	}


}

?>