<?php

namespace App;

use App\Commands\AbstractCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DefaultCommand extends Command
{
    /**
     * @var \App\CommandResolver
     */
    private $commandResolver;

    public function __construct()
    {
        parent::__construct();
        $this->commandResolver = new CommandResolver();
    }

    protected function configure()
    {
        $this->setName('base');
        $this->addArgument('separator', InputArgument::REQUIRED, 'Тип разделителя');
        $this->addArgument('method', InputArgument::REQUIRED, 'Команда');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $separator = $input->getArgument('separator');
        $method = $input->getArgument('method');

        $separator = $this->resolveSeparator($separator);
        $command = $this->resolveCommand($method);

        $output->writeln('Выбранный разделитель: ' . $separator->getValue());
        $output->writeln('Выбранный метод: ' . $command->getName());
        $output->writeln('');

        $config = Config::getInstance();
        $config->setSeparator($separator);

        $command->execute($output);
    }

    private function resolveSeparator($separator): Separator
    {
        return new Separator((string)$separator);
    }
    private function resolveCommand($method): AbstractCommand
    {
        return $this->commandResolver->resolve($method);
    }
}