<?php

namespace App;

use InvalidArgumentException;

class Separator
{
    private const SEPARATORS = [
        'semicolon' => ';',
        'comma' => ',',
        'tab' => '   ',
    ];
    private $separator;

    public function __construct(string $separator = 'comma')
    {
        if (!array_key_exists($separator, self::SEPARATORS)) {
            throw new InvalidArgumentException('Неизвестный разделитель: ' . $separator);
        }
        $this->separator = self::SEPARATORS[$separator];
    }

    public function getValue(): string
    {
        return $this->separator;
    }
}