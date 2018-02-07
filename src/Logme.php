<?php

namespace Mentalist\Logme;

use \Mentalist\Logme\Exceptions\FileDoesNotExistException;
use \Mentalist\Logme\Exceptions\FileNotWritableException;

class Logme
{

    var $timezone = 'UTC';

    static $levels = [
        'info', 'debug', 'warn', 'error'
    ];

    var $level = 'info';

    var $dir = '/var/www/logs/';

    var $file = '';
    var $filename = '';

    /**
     * Create a new Logme Instance
     *
     * @param string $basedir  The directory to write the log file to
     * @param string $filename The name of the file to write to
     *
     * @return void
     */
    public function __construct($basedir, $filename = 'logme.log')
    {

        $this->dir = $basedir;
        $this->filename = $filename;

        date_default_timezone_set($this->timezone);

        if( !is_dir($basedir) ) {
            throw new FileDoesNotExistException("{$basedir} is not a directory");
        }
        if( !is_writeable($basedir) ) {
            throw new FileNotWritableException("{$basedir} is not writeable");
        }

        $this->file = "{$this->dir}{$this->filename}";

    }

    /**
     * Set the log level
     * @param string $level One of self::$levels
     */
    public function setLevel($level) {
        $this->level = $level;
    }

    /**
     * Set the timezone for dates
     * @param string $timezone A valid PHP timezone https://secure.php.net/manual/en/timezones.php
     */
    public function setTimezone($timezone) {
        $this->timezone = $timezone;
    }

    /**
     * Log a info line
     * @param string $message The message to add to the log
     * @param bool|array  $extra   An array of key/value pairs of any extra data to log.
     *
     * @return void
     */
    public function info($message, $data = []) {
        $this->setLevel('info');
        $this->write($message, $data);
    }

    /**
     * Log a debug line
     * @param string $message The message to add to the log
     * @param bool|array  $extra   An array of key/value pairs of any extra data to log.
     *
     * @return void
     */
    public function debug($message, $data = []) {
        $this->setLevel('debug');
        $this->write($message, $data);
    }

    /**
     * Log a warning line
     * @param string $message The message to add to the log
     * @param bool|array  $extra   An array of key/value pairs of any extra data to log.
     *
     * @return void
     */
    public function warn($message, $data = []) {
        $this->setLevel('warn');
        $this->write($message, $data);
    }

    /**
     * Log a error line
     * @param string $message The message to add to the log
     * @param bool|array  $extra   An array of key/value pairs of any extra data to log.
     *
     * @return void
     */
    public function error($message, $data = []) {
        $this->setLevel('error');
        $this->write($message, $data);
    }

    /**
     * Simple logging method.
     *
     * Will only log if debugging is enabled of the $force parameter is set to true.
     *
     * @param string $message The message to add to the log
     * @param bool|array  $extra   An array of key/value pairs of any extra data to log.
     *                             If it's a boolean, 'True' or 'False' will be written
     * @param string $level   The logging level. One of:
     *  debug (the least serious)
     *  info
     *  warning
     *  error
     *  fatal (the most serious)
     * @param bool $force     If true, will ignore debug setting. Default is false.
     */
    function write($message, $extra = array()) {

        // If file doesn't exist, create it
        try {
            $fh = fopen( $this->file, 'a+' );
        } catch(\Exception $e) {
            throw $e;
        }

        // If file was successfully created
        if ($fh) {
            $line = $this->getLine($message, $extra);
            fwrite ( $fh, $line );
        }

        try {
            fclose( $fh );
        } catch(\Exception $e) {
            throw $e;
        }
    }

    private function getLine($message, $extra) {
        $now = date( 'Y-m-d H:i:s' );

        if( is_bool($extra) ) {
            $_string = " | " . ($extra ? 'True' : 'False');
        } elseif( is_string($extra) ) {
            $_string = " | " . $extra;
        } else {
            $_string = empty( $extra ) ? "" : " | " . print_r( $extra, true );
        }

        return "{$now} [{$this->level}]\t{$message} {$_string} \n";
    }
}
