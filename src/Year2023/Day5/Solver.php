<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day5;

use AdventOfCode\AbstractSolver;
use AdventOfCode\SolverInterface;

final class Solver extends AbstractSolver implements SolverInterface
{
    public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);

        $seeds = explode(' ', trim(str_replace('seeds: ', '', $file[0])));

        unset($file[0]);
        $allTotalSeeds = [];
        $lowestSeed = null;

        foreach ($seeds as $seed) {
            $seed = (int)$seed;
            echo PHP_EOL;
            echo "\033[34m$seed\033[0m - ";
            foreach ($file as $row) {
                $row = trim($row);
                if ($row === '') {
                    continue;
                }

                if (str_contains($row, 'map:')) {
                    if (!is_null($lowestSeed) && !str_contains($row, 'seed-to-soil')) {
                        $seed = $lowestSeed;
                    }
                    $lowestSeed = null;
                    echo PHP_EOL;
                    continue;
                }


                $numbers = explode(' ', $row);
                $dRangeStart = (int)$numbers[0];
                $sRangeStart = (int)$numbers[1];
                $rangeLength = (int)$numbers[2];

                if ($seed >= $sRangeStart && $seed < ($sRangeStart + $rangeLength)) {
                    $newSeed = $seed + ($dRangeStart - $sRangeStart);
                    if (is_null($lowestSeed) || $lowestSeed > $newSeed) {
                        $lowestSeed = $newSeed;
                    }
                    echo "\033[34m$newSeed\033[0m - ";
                } else {
                    echo "\033[32m$seed\033[0m - ";
                }
            }
            $allTotalSeeds[] = $newSeed;
            echo "\033[31m$newSeed\033[0m - ";
            echo PHP_EOL;
        }

        echo min($allTotalSeeds);
    }

    public function solutionTwo(): void
    {
    }
}