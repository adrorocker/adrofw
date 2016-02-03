<?php

use Adroframework\Session\Session;
use Adroframework\Config\Config;

/**
* Lang Manager 
*/
class I18n
{
    public function __construct()
    {
        
    }

    public static function t($message = '') 
    {
        $messages = self::getLang();
        if(null !== $messages) {
            if(array_key_exists($message, $messages)) {
                $message = $messages[$message];
            }
        }
        return $message;
    }

    public static function getLang()
    {
        Session::init();
        $lang = Session::get('lang');
        if (!$lang) {
            $lang = 'en';
        } 
        $path = APP_PATH.'lang/'.$lang.'/messages.php';
        if(file_exists($path)) {
            $lang = require $path;
            return $lang;
        }
        return null;
    }
}