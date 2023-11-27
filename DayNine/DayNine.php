<?php

declare(strict_types=1);

namespace Day;

use Day;

class DayNine implements Day
{
    public function solutionOne(): void
    {
        $this->calculate();
    }

    public function calculate(): void
    {
        $file = file(__DIR__ . '/day_nine_test.txt');

        $count = 0;

        foreach ($file as $row) {
            $row = explode(' ', trim($row));
            if ($row[2] > 2) {
            }
        }
        var_dump($count);
    }

    public function solutionTwo(): void
    {
        // TODO: Implement solutionTwo() method.
    }
}