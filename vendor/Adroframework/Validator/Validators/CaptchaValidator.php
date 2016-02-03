<?php

use Adroframework\Session\Session;
/**
* 
*/
class CaptchaValidator
{

    public function validate($fields, $form, $message)
    {
        Session::init();
        $errors = array();
        foreach ($fields as $filed) {
            $c = $form->getAttribute($filed);
            $c = strtolower($c);
            if ($c != Session::get('captcha')) {
                $errors[$filed] = $message;
            }
        }
        return $errors;
    }
}