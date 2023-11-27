<?php

declare(strict_types=1);

namespace AdventOfCode\Year2022\Day1;

use AdventOfCode\AbstractSolver;
use AdventOfCode\SolverInterface;

class Solver extends AbstractSolver implements SolverInterface
{
    public function solutionOne(): void
    {
        echo $this->formula()['total'];
    }

    private function formula(): array
    {
        $fh = $this->getTestScenario(__DIR__);

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