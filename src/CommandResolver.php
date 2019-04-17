<?php

namespace App;

use App\Commands\AbstractCommand;
use App\Commands\CountAverageLines;
use App\Commands\ReplaceDates;
use InvalidArgumentException;

class CommandResolver
{
    private const COMMANDS = [
        'replaceDates' => ReplaceDates::class,
        'countAverageLineCount' => CountAverageLines::class,
    ];

    public function resolve(string $command): AbstractCommand
    {
        if (!array_key_exists($command, self::COMMANDS)) {
            throw new InvalidArgumentException('Неизвестная команда: ' . $command);
        }
        $commandClass = self::COMMANDS[$command];

        return new $commandClass();
    }
}