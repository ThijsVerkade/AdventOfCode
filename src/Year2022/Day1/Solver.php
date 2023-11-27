<?php

declare(strict_types=1);

namespace Year2022\DayOne;

use SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        echo $this->formula()['total'];
    }

    private function formula(): array
    {
        $fh = file(__DIR__ . '/test_scenario_1.txt');

        $total = 0;
        $temp = 0;
        $array = [];

        foreach ($fh as $key => $item) {
            $value = trim($item);

            if ($value === '') {
                if ($temp > $total) {
                    $total = $temp;
                }
                $array[$key] = $temp;
                $temp = 0;
                continue;
            }

            $temp += (int)$item;
        }

        return [
            'total' => $total,
            'array' => $array,
        ];
    }

    public function solutionTwo(): void
    {
        $array = $this->formula()['array'];

        echo array_sum(array_slice($array, -3, 3, true));
    }
}