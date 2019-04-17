<?php

namespace App;

class WrongDateHelper
{
    private const WRONG_PATTERN = '#([0-2][\d]|3[01])/(0[1-9]|1[0-2])/([\d]{2})#';

    /**
     * @param string $data
     *
     * @return array
     */
    public function matchWrongDates(string $data): int
    {
        $count = preg_match_all(self::WRONG_PATTERN, $data, $matches);

        return (int)$count;
    }

    public function replaceWrongDates(string $data)
    {
        return preg_replace(self::WRONG_PATTERN, '$2-$1-$3', $data);
    }
}