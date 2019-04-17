<?php

namespace App;

use App\Commands\AbstractCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Config
{
    private static $instance;
    /**
     * @var \App\Separator
     */
    private $separator;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setSeparator(Separator $separator)
    {
        $this->separator = $separator;
    }

    /**
     * @return \App\Separator
     */
    public function getSeparator(): Separator
    {
        return $this->separator ?? new Separator();
    }
}