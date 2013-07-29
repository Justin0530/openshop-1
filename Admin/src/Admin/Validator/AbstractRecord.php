<?php

namespace Admin\Validator;

use Zend\Validator\AbstractValidator;

abstract class AbstractRecord extends AbstractValidator
{
    /**
     * Error constants
     */
    const ERROR_NO_RECORD_FOUND = 'noRecordFound';
    const ERROR_RECORD_FOUND    = 'recordFound';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_NO_RECORD_FOUND => "没有查询到记录",
        self::ERROR_RECORD_FOUND    => "查询到一条记录",
    );

    /**
     * @var UserInterface
     */
    protected $mapper;

    /**
     * @var string
     */
    protected $key;

    /**
     * Required options are:
     *  - key     Field to use, 'emial' or 'username'
     */
    public function __construct(array $options)
    {
        if (!array_key_exists('key', $options)) {
            throw new \Zend\Validator\Exception\InvalidArgumentException('No key provided');
        }

        $this->setKey($options['key']);

        parent::__construct($options);
    }

    /**
     * getMapper
     *
     * @return UserInterface
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * setMapper
     *
     * @param  $mapper
     * @return AbstractRecord
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * Get key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set key.
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Grab the user from the mapper
     *
     * @param string $value
     * @return mixed
     */
    protected function query($value)
    {
        $result = false;

        switch ($this->getKey()) {
            case 'email':
                $result = $this->getMapper()->findByEmail($value);
                break;

            case 'name':
                $result = $this->getMapper()->findByName($value);
                break;

            default:
                throw new \Exception('Invalid key used in Admin validator');
                break;
        }

        return $result;
    }
}
