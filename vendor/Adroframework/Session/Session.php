<?php


/**
 * Session handler
 *
 * @package Adroframework
 * @subpackage Session
 * @author Alejandro Morelos <alejandro.morelos@jarwebdev.com>
 */

namespace Adroframework\Session;

/**
 * This class take care of all session process
 */
class Session 
{
    /**
     * Initialize session.
     */
    public static function init()
    {
        @session_start();
    }

    /**
     * Set a session with a key-value pair.
     * 
     * @param string $key   Name of the session.
     * @param string $value Value of ther session.
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Unset a session with a key name.
     * 
     * @param string $key   Name of the session.
     */
    public static function delete($key)
    {
        if (isset( $_SESSION[$key]))
        unset($_SESSION[$key]);
    }
    
    /**
     * Get the value of the key session.
     * 
     * @param string $key Name of the session key.
     * @return mixed
     */
    public static function get($key)
    {   
        if (isset( $_SESSION[$key]))
        return $_SESSION[$key];
    }

    /**
     * Destroy all the sessions.
     */
    public static function destroy()
    {
        //unset($_SESSION);
        @session_destroy();
    }
}