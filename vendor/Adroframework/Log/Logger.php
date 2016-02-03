<?php

/**
 * Logg writer
 * 
 * @author Alejandro Morelos <alejandro.morelos@jarwebdev.com>
 * @package Adroframework
 * @subpackage Log
 */

namespace Adroframework\Log;

class Logger
{

    /* @const Default tag. */
    const DEFAULT_TAG = '--';

    /**
     * Private method that will write the text messages into the log file.
     * 
     * @param string $errorlevel There are 4 possible levels: INFO, WARNING, DEBUG, ERROR
     * @param string $value The value that will be recorded on log file.
     * @param string $tag Any possible tag to help the developer to find specific log messages.
     */
    private static function log($errorlevel = 'INFO', $value = '', $tag) 
    {
        $datetime = @date("Y-m-d H:i:s");
        $file = __DIR__.'/../../../logs/log.csv';
        if (!file_exists($file)) {
            $dir = __DIR__.'/../../../logs/';
            if (!file_exists($dir)) {
                @mkdir(__DIR__.'/../../../logs/',0755,true);
            }
            $headers = "DATETIME,ERRORLEVEL,TAG,VALUE,LINE,FILE" . "\n";
        }
        $fd = fopen($file, "a");
        if (@$headers) {
            fwrite($fd, $headers);
        }
        $debugBacktrace = debug_backtrace();
        $line = $debugBacktrace[1]['line'];
        $file = $debugBacktrace[1]['file'];
        $value = preg_replace('/\s+/', ' ', trim($value));
        $entry = array($datetime,$errorlevel,$tag,$value,$line,$file);
        fputcsv($fd, $entry, ',');
        fclose($fd);
    }
    /**
     * Function to write non INFOrmation messages that will be written into $LOGFILENAME.
     * 
     * @param string $value
     * @param string $tag 
     */
    public static function info($value = '', $tag = self::DEFAULT_TAG) 
    {
        self::log('INFO', $value, $tag);
    }
    /**
     * Function to write WARNING messages that will be written into $LOGFILENAME.
     *
     * Warning messages are for non-fatal errors, so, the script will work properly even
     * if WARNING errors appears, but this is a thing that you must ponderate about.
     * 
     * @param string $value
     * @param string $tag 
     */
    public static function warning($value = '', $tag = self::DEFAULT_TAG) 
    {
        self::log('WARNING', $value, $tag);
    }
    /**
     * Function to write ERROR messages that will be written into $LOGFILENAME.
     *
     * These messages are for fatal errors. Your script will NOT work properly if an ERROR happens, right?
     * 
     * @param string $value
     * @param string $tag 
     */
    public static function error($value = '', $tag = self::DEFAULT_TAG) 
    {
        self::log('ERROR', $value, $tag);
    }
    /**
     * Function to write DEBUG messages that will be written into $LOGFILENAME.
     *
     * DEBUG messages are for variable values and other technical issues.
     * 
     * @param string $value
     * @param string $tag 
     */
    public static function debug($value = '', $tag = self::DEFAULT_TAG) 
    {
        self::log('DEBUG', $value, $tag);
    }
}