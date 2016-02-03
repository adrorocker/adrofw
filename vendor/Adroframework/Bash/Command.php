<?php

/**
 * Command class
 *
 * @author Alejandro Morelos <alejandro.morelos@jarwebdev.com>
 */

if (file_exists(__DIR__.'/Interface/DialogInterface.php')) {
    require_once __DIR__.'/Interface/DialogInterface.php';
}

class Command
{
    protected $command;
    protected $interface;

    public function __construct($command = false, $interface = false)
    {
        $this->command = $command;
        $this->interface = $interface;
    }

    /**
     * Run command
     * TODO: Impement command handling and diferent interface
     */
    public function run()
    {
        if (false === $this->command && false === $this->interface) {
            try {
                $interface = new DialogInterface();
                $interface->run();
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }

    /**
     * Send output to STDOUT
     * @param  string $output message
     * @return void
     */
    private function puts($output)
    {
        echo $output.PHP_EOL;
    }

    /**
     * @param  string $output
     * @return void
     */
    private function debug($output)
    {
        $output = "\033[0;96mdebug:\033[0m $output";
        $this->puts($output);
    }

    /**
     * @param  string $output
     * @return void
     */
    private function info($output)
    {
        $output = "\033[0;32minfo:\033[0m  $output";
        $this->puts($output);
    }

    /**
     * @param  string $output
     * @return void
     */
    private function warn($output)
    {
        $output = "\033[1;93mwarn:  $output\033[0m";
        $this->puts($output);
    }

    /**
     * @param  string $output
     * @return void
     */
    private function error($output)
    {
        fputs(STDERR, "\033[0;31merror:\033[0m $output".PHP_EOL);
        exit(1);
    }

    /**
     * Terminate program normally
     * @return void
     */
    private function terminate()
    {
        exit;
    }
}