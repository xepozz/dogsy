<?php

namespace App\Commands;

use App\Separator;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand
{
    /**
     * @var \App\Separator
     */
    protected $separator;

    abstract public function execute(OutputInterface $output);

    public function setSeparator(Separator $separator)
    {
        $this->separator = $separator;
    }

    public function getName(): string
    {
        return static::class;
    }
}