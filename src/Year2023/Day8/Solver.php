<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day8;

use AdventOfCode\AbstractSolver;
use AdventOfCode\Enums\Scenario;
use AdventOfCode\SolverInterface;

final class Solver extends AbstractSolver implements SolverInterface
{
    public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);
        $instructions = str_split(trim($file[0]));

        unset($file[0]);
        $elements = [];

        foreach ($file as $row) {
            if (trim($row) === '') {
                continue;
            }
            $row = explode(' = ', $row);
            $key = $row[0];
            $set = explode(', ', trim(str_replace(['(', ')'], '', $row[1])));

            $elements[$key] = [
                'L' => $set[0],
                'R' => $set[1],
            ];
        }

        $nextKey = 'AAA';
        $lastKey = 'ZZZ';
        $total = 0;
        while ($nextKey !== $lastKey) {
            foreach ($instructions as $instruction) {
                $nextKey = $elements[$nextKey][$instruction];
                $total++;

                if ($nextKey === $lastKey) {
                    break;
                }
            }
        }

        echo $total;
    }

    public function solutionTwo(): void
    {
        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);
        $instructions = str_split(trim($file[0]));

        unset($file[0]);
        $elements = [];
        $startingPoints = [];

        foreach ($file as $row) {
            if (trim($row) === '') {
                continue;
            }
            $row = explode(' = ', $row);
            $key = $row[0];

            if (str_split($key)[2] === 'A') {
                $startingPoints[] = $key;
            }

            $set = explode(', ', trim(str_replace(['(', ')'], '', $row[1])));

            $elements[$key] = [
                'L' => $set[0],
                'R' => $set[1],
            ];
        }

        $totalPoints = [];
        foreach ($startingPoints as $nextKey) {
            $total = 0;
            $valid = true;
            while ($valid) {
                foreach ($instructions as $instruction) {
                    $nextKey = $elements[$nextKey][$instruction];
                    $total++;

                    if ($nextKey[2] === 'Z') {
                        $valid = false;
                        break;
                    }
                }
            }
            $totalPoints[] = $total;
        }

        $t = gmp_init(1);
        foreach ($totalPoints as $points) {
            $t = gmp_lcm($t, $points);
        }

        echo $t;
    }
}