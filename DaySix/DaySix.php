<?php

declare(strict_types=1);

namespace Day;

use Day;

class DaySix implements Day
{
    public function solutionOne(): void
    {
        $this->calculate(4);
    }

    private function calculate(int $length): void
    {
        $file = file(__DIR__ . '/day_six.txt');

        for ($i = 0; $i <= strlen($file[0]); $i++) {
            if ($i > ($length - 1)) {
                $prevStr = substr($file[0], $i - $length, $length);
                if (count(array_count_values(str_split($prevStr))) == $length) {
                    echo $i;
                    break;
                }
            }
        }
    }

    public function solutionTwo(): void
    {
        $this->calculate(14);
    }
}