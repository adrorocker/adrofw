<?php

namespace Adroframework\Validator;

use Adroframework\Loader\LocalizeClass;

/**
* 
*/
class Validator
{
    protected $rules;
    protected $form;
    protected $localizeClass;
    
    public function __construct($rules, $form)
    {
        $this->rules = $rules;
        $this->form = $form;
        $this->localizeClass = new LocalizeClass();;
    }

    public function validate()
    {
        $errors = array();
        foreach ($this->rules as $rule) {
            $fields = explode(',', $rule[0]);
            $validator = $rule[1];
            $message = $rule['message'];
            $validator = $this->localizeClass->getValidator($validator);
            $tmp = $validator->validate($fields,$this->form,$message);
            $errors = array_merge($errors, $tmp);
        }
        
        return $errors;
    }
}