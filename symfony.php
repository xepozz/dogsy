#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use App\DefaultCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$command = new DefaultCommand();
$application->add($command);
$application->setDefaultCommand($command->getName(), true);
$application->run();