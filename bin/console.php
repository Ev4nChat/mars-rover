<?php

use App\Command\MarsRoverCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

require dirname(__DIR__) . '/vendor/autoload.php';

// Create the Symfony Console application
$application = new Application();

// Add your commands to the application
$application->add(new MarsRoverCommand('app:mars-rover'));

// Run the application
$application->run(new ArgvInput(), new ConsoleOutput());
