<?php

/**
 * Dialog Interface
 *
 * TODO: Extend this class to handle deply and sync commands
 *
 * @author Alejandro Morelos <alejandro.morelos@jarwebdev.com>
 */

class DialogInterface
{
    /**
     * DB commands to run
     */
    protected $dbCommands = array(
            "cd data/bash/; ./reset.sh" => array("Description" => "Reset DB"),
            "cd data/bash/; ./makedump.sh" => array("Description" => "Make dump"),
        );


    /**
     * Migration commands to run
     */
    protected $migrationCommands = array(
            "php scripts/Migration.php" => array("Description" => "Run Migrations"),
        ); 

    /**
     * Scopes of command to run
     */
    protected $scopes = array(
            'db',
            'migration',
        );

    protected $scope;


    /**
     * Dependencies needed for the interface
     */
    protected $dependencies = array(
            'dialog',
        );

    /**
     * Environment to run the commands
     */
    protected $env;

    /**
     * Path whare the repo resides
     */
    protected $path;

    /**
     * Comand to run
     */
    protected $command;

    /**
     * Wheter if sudo need to be use in commands
     */
    protected $sudo;

    /**
     * Sudo password
     */
    protected $sudopass;

    /**
     * OS
     */
    protected $os;

    /**
     * Aliases
     */
    protected $aliases = array(
            'mysqldump' => '/usr/local/mysql/bin/mysqldump',
            'mysql' => '/usr/local/mysql/bin/mysql',
        );

    public function __construct()
    {
        if ('cli' !== PHP_SAPI) {
            $this->error('You are not in the cli');
        }
        $this->getOS();
        /**
         * Check dependencies
         */
        $this->checkDependencies();

        /**
         * Read configurations
         */
        $configFile = __DIR__.'/../Config/Configuration.php';
        if ( ! file_exists($configFile)) {
            $this->error('Please copy the Configuration.php.dist into Configuration.php and try again');
        }
        $settings = require_once $configFile;

        /**
         * Set the configurations
         */
        $this->setSettings($settings);

    }

    /**
     * Run the interface
     */
    public function run()
    {
        foreach ($this->scopes as $scope) {
            $command[] = "$scope '' ";
        }
        $command = 'dialog --keep-tite --stdout --clear --menu "Choose a scope:" 12 50 8 '.implode((string) null, $command).'2> /dev/null';

        $read = (string) exec($command, $out);

        if (false === (bool) $read) {
            $this->info("Cancel caught, exiting");
        } else {
            $this->setScope($read);
            $this->promtCommands();
        }
    }

    /**
     * Show commands
     */
    protected function promtCommands()
    {
        $commands = array();
        $count = 1;
        switch ($this->scope) {
            case 'db':
                $c = $this->dbCommands;
                break;

            case 'migration':
                $c = $this->migrationCommands;
                break;
        }
        foreach ($c as $command => $descrition) {
            array_push($commands, $command);
            $desc = $descrition['Description'];
            $desc = str_replace(' ', '-', $desc);
            $cmd[] = $count . "-$desc '' ";
            $count++;
        }
        $command = 'dialog --keep-tite --stdout --clear --menu "Choose a command:" 15 100 8 '.implode((string) null, $cmd).'2> /dev/null';

        $read = (string) exec($command, $out);
        if (false === (bool) $read) {
            $this->info("Cancel caught, exiting");
        } else {
            $commadNumber = $this->getCommandNumber($read);
            $command = $this->getFormatedCommand($commands, $commadNumber);
            $this->setCommand($command);
            $this->runCommand();
        }
    }

    /**
     * Set scope
     * @param  string $scope scope
     * @return void
     */
    protected function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * Set command
     * @param  string $command command
     * @return void
     */
    protected function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * Get the command in correct format
     * @param  array $commands commands
     * @param  string $commandNumber command number
     * @return string
     */
    protected function getFormatedCommand($commands, $commadNumber)
    {
        $n = $commadNumber - 1;
        $c = $commands[$n];
        $command = $c;
        if (isset($this->sudo) && true === $this->sudo && strpos($c, '-rf')) {
            $c = 'echo %s | sudo -S ' . $c; 
            $command = sprintf($c,$this->sudopass);
        }
        if (isset($this->os) && 'osx' == $this->os && strpos($c, 'mysql')) {
            $command = str_replace('mysql', $aliases['mysql'], $c); 
        }
        if (isset($this->os) && 'osx' == $this->os && false !== strpos($c, 'mysqldump')) {
            $command = str_replace('mysqldump', $this->aliases['mysqldump'], $c); 
        }
        return $command;
    }

    /**
     * Get number of comand
     * @param  string $command command
     * @return string
     */
    protected function getCommandNumber($commad)
    {
        $commad = explode('-', $commad);
        return $commad[0];
    }

    /**
     * Set all settings
     * @param  array $settings settings
     * @return void
     */
    protected function setSettings(array $settings)
    {
        foreach ($settings as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Run command
     * TODO: Optimize this to run complex comands
     */
    protected function runCommand()
    {
        $command = $this->command;
        $this->info('Running command '.$command);
        $path = $this->getPath();
        $command = "(cd $path; $command 2>&1)";
        passthru($command);
        $this->info('Done.');
        $this->terminate();
    }

    /**
     * Get the path where the repo resides
     * This is useful when an alias is set, so you use this from anywhare in the command line
     */
    protected function getPath()
    {
        return $this->path;
    }

    /**
     * Check if all programs needed are installed
     */
    protected function checkDependencies()
    {
        foreach ($this->dependencies as $dependency) {
            $has = $this->haveDependence($dependency);
            if (!$has) {
                $message = sprintf("You need to install %s", $dependency);
                $this->warn($message);
                $this->terminate();
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

    /**
     * Check if system have some program installed
     * @param  string $program
     * @return bool
     */
    private function haveDependence($program)
    {
        assert('is_string($program)');
        return (bool) exec("which $program 2> /dev/null");
    }

    private function getOS()
    {
        $os = (string) exec('uname',$out);
        if ($os == 'Darwin')  {
            $this->os = 'osx';
        } else {
            $this->os = 'linux';
        }
    }
}