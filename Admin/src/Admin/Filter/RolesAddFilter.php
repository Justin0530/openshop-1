<?php
namespace Admin\Filter;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;

class RolesAddFilter extends ProvidesEventsInputFilter
{
    
    protected $nameValidator;
    
    public function __construct($nameValidator){
        $this->nameValidator = $nameValidator;
        
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => '2',
                        'max' => '16',
                    ),
                ),
                $this->getNameValidator(),
            ),
        ));
    }
    
	public function getNameValidator() {
		return $this->nameValidator;
	}

	public function setNameValidator($nameValidator) {
		$this->nameValidator = $nameValidator;
	}


}

?>