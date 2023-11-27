<?php

declare(strict_types=1);

namespace Year2022\DaySix;

use SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        $this->calculate(4);
    }

    private function calculate(int $length): void
    {
        $file = file(__DIR__ . '/test_scenario_1.txt');

        for ($i = 0, $iMax = strlen($file[0]); $i <= $iMax; $i++) {
            if ($i > ($length - 1)) {
                $prevStr = substr($file[0], $i - $length, $length);
                if (count(array_unique(str_split($prevStr))) == $length) {
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