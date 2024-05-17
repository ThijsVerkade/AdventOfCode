<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day12;

use AdventOfCode\AbstractSolver;
use AdventOfCode\SolverInterface;

final class Solver extends AbstractSolver implements SolverInterface
{
    public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);

        foreach ($file as $row) {
            $row = explode(' ', $row);
            $numbers = explode(',', $row[0]);
            var_dump($numbers);
            var_dump($row);
        }
    }

    public function solutionTwo(): void
    {
        // TODO: Implement solutionTwo() method.
    }
}