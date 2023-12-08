<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day6;

use AdventOfCode\AbstractSolver;
use AdventOfCode\Enums\Scenario;
use AdventOfCode\SolverInterface;

final class Solver extends AbstractSolver implements SolverInterface
{
    public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);
        $times = array_filter(explode(' ', $file[0]));
        $records = array_filter(explode(' ', $file[1]));
        $races = array_combine($times, $records);
        $totalCounts = [];
        foreach ($races as $time => $record) {
            $count = 0;
            for ($i = 1; $i <= (int)$time; $i++) {
                $startTime = (int)$time - $i;
                $distance = $startTime * $i;
                if ($distance > (int)$record) {
                    $count++;
                }
            }
            $totalCounts[] = $count;
        }

        $t = 1;
        foreach (array_filter($totalCounts) as $item) {
            $t *= $item;
        }
        echo $t;
    }

    public function solutionTwo(): void
    {
        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);
        $time = array_filter(explode(':', str_replace(' ', '', $file[0])))[1];
        $record = array_filter(explode(':', str_replace(' ', '', $file[1])))[1];
        $count = 0;

        for ($i = 1; $i <= (int)$time; $i++) {
            $startTime = (int)$time - $i;
            $distance = $startTime * $i;
            if ($distance > (int)$record) {
                $count++;
            }
        }

        echo $count;
    }
}