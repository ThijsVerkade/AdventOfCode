<?php

declare(strict_types=1);

namespace AdventOfCode\Year2022\Day9;

use AdventOfCode\SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        $this->calculate();
    }

    public function calculate(): void
    {
        $file = file(__DIR__ . '/test_scenario_2.txt');

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