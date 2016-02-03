<?php


/**
* 
*/
class FileValidator
{

    public function validate($fields, $form, $message)
    {
        $errors = array();
        foreach ($fields as $filed) {
            $f = $form->getAttribute($filed);
            if ($f['name'][$filed] == '') {
                $errors[$filed] = $message;
            }
            
        }
        return $errors;
    }
}