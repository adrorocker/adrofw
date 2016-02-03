<?php

/**
 * Form template
 *
 * @package Adroframework
 * @subpackage Form
 * @author Alejandro Morelos <alejandro.morelos@jarwebdev.com>
 */

namespace Adroframework\Form;

use Adroframework\Validator\Validator;

class Form
{
    static $className;
    public $_errors = array();

    public function __construct() {
        self::$className = get_class($this);
    }

    public function start($htmlOptions = array(),$method = 'post')
    {
        $formStartHtml = '<form method="'.$method.'"';
        foreach ($htmlOptions as $prop => $value) {
            $formStartHtml .= ' ' . $prop . '="' . $value . '"';
        }
        $formStartHtml .= '>' . PHP_EOL;

        echo $formStartHtml;
    }

    public function end()
    {
        echo '</form>' . PHP_EOL;
    }

    public function rules()
    {
        return array();
    }

    public function validate()
    {
        $rules = $this->rules();
        $validator = new Validator($rules, $this);
        $this->_errors = $validator->validate();
        $errors = $this->getErrors();
        if (empty($errors)) {
            return true;
        }
        return false;

    }

    public function attributeLabels()
    {
        return array();
    }

    public function setAttributes($attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->{$name} = $value;
        }
    }

    public function setAttribute($name, $value)
    {
        if (isset($this->{$name})) {
            $this->{$name} = $value;
        }
    }

    public function getAttribute($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function getAttributes()
    {
        $classVars = get_class_vars(self::$className);
        unset($classVars['className']);
        unset($classVars['_errors']);
        return $classVars;
    }

    public function clean() 
    {
        foreach ($this as $key => $value) {
            $this->$key = null;
        }
    }

    public function getError($name)
    {
        if (isset($this->_errors[$name])){
            return $this->_errors[$name];
        }
        return false;
    }

    public function setError($name, $error)
    {
        $this->_errors[$name] = $error;
    }

    /**
     * Validators
     */

    protected function requiredValidator($rule)
    {
        $fields = explode(',', $rule[0]);
        foreach ($fields as $key => $value) {
            if (!$this->{$value}) {
                $this->_errors[$value] = $rule['message'];
            }
        }
    }


    public function error($name, $htmlOptions = array())
    {
        if ($this->getError($name) && $_POST) {
            $formStartHtml = '<div id="' . self::$className . '_' . $name . '_error"';
            foreach ($htmlOptions as $prop => $value) {
                $formStartHtml .= ' ' . $prop . '="' . $value . '"';
            }
            $formStartHtml .= '>' . $this->_errors[$name];
            $formStartHtml .= '</div>' . PHP_EOL;

            echo $formStartHtml;
        }
    }
}