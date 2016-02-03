<?php


/**
* 
*/
class RequiredValidator
{

    public function validate($fields, $form, $message)
    {
        $errors = array();
        foreach ($fields as $filed) {
            $f = $form->getAttribute($filed);
            if (null === $f || false === $f || '' === $f) {
                $errors[$filed] = $message;
            }
            
        }
        return $errors;
    }
}