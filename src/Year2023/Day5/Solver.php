<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day5;

use AdventOfCode\AbstractSolver;
use AdventOfCode\Enums\Scenario;
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
        //        foreach ($seeds as $index => $seed) {
        //            if ($index === 0) {
        //                $first = (int)$seed;
        //                continue;
        //            }
        //
        //            $newSeeds[] = range($first, $first + (int)$seed - 1);
        //            $first = $first;
        //        }

        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);
        ini_set('memory_limit', '-1');
        $seeds = explode(' ', trim(str_replace('seeds: ', '', $file[0])));
        unset($file[0]);

        $t = microtime(true);
        $lowestSeed = null;
        $seedInstructions = [];
        $map = '';
        foreach ($file as $row) {
            $row = trim($row);
            if ($row === '') {
                continue;
            }

            if (str_contains($row, 'map:')) {
                if (!is_null($lowestSeed) && strpos($row, 'seed-to-soil') === false) {
                    $seed = $lowestSeed;
                }
                $map = $row;
                $lowestSeed = null;
                continue;
            }

            $numbers = explode(' ', $row);
            $dRangeStart = (int)$numbers[0];
            $sRangeStart = (int)$numbers[1];
            $rangeLength = (int)$numbers[2];
            $seedInstructions[$map][] = [
                'dRangeStart' => $dRangeStart,
                'sRangeStart' => $sRangeStart,
                'rangeLength' => $rangeLength
            ];
        }
        $seeds = [
            [79, 14],
            [55, 13]
        ];

        foreach ($seedInstructions as $maps) {
            foreach ($maps as $seedCheck) {
                foreach ($seeds as $index => $seed) {
                    if ($seed[0] >= $seedCheck['dRangeStart']) {
                        if (($seed[0] + $seed[1]) <= ($seedCheck['dRangeStart'] + $seedCheck['rangeLength'])) {
                            $seeds[$index] = [
                                $seed[0] + ($seedCheck['dRangeStart'] - $seedCheck['sRangeStart']),
                                $seed[1]
                            ];
                        } elseif ($seed[0] > ($seedCheck['dRangeStart'] + $seedCheck['rangeLength'])) {
                            continue;
                        } elseif (($seed[0] + $seed[1]) > ($seedCheck['dRangeStart'] + $seedCheck['rangeLength'])) {
                            $seeds[$index] = [
                                $seedCheck['dRangeStart'] + $seedCheck['rangeLength'] + 1,
                                ($seed[0] + $seed[1]) - ($seedCheck['dRangeStart'] + $seedCheck['rangeLength']) - 1
                            ];
                            $seeds[] = [
                                $seed[0] + ($seedCheck['dRangeStart'] - $seedCheck['sRangeStart']),
                                $seed[0] - ($seedCheck['dRangeStart'] + $seedCheck['rangeLength'])
                            ];
                        }
                    } elseif (($seed[0] + $seed[1]) >= $seedCheck['dRangeStart']) {
                        if (($seed[0] + $seed[1]) <= ($seedCheck['dRangeStart'] + $seedCheck['rangeLength'])) {
                            $newRange = $seed[0] + $seed[1] - $seedCheck['dRangeStart'];
                            $seeds[$index] = [
                                $seedCheck['dRangeStart'] + ($seedCheck['dRangeStart'] - $seedCheck['sRangeStart']),
                                $newRange
                            ];
                            $seeds[] = [
                                $seed[0],
                                $seed[1] - $newRange
                            ];
                        } else {
                            //lowest
                            $seeds[$index] = [
                                $seed[0] + 1,
                                $seedCheck['dRangeStart'] - $seed[0] - 1
                            ];
                            //middle
                            $seeds[] = [
                                $seedCheck['dRangeStart'] + ($seedCheck['dRangeStart'] - $seedCheck['sRangeStart']),
                                ($seedCheck['dRangeStart'] + $seedCheck['rangeLength']) - $seedCheck['dRangeStart']
                            ];
                            //highest
                            $seeds[] = [
                                $seedCheck['dRangeStart'] + $seedCheck['rangeLength'] + 1,
                                ($seed[0] + $seed[1]) - ($seedCheck['dRangeStart'] + $seedCheck['rangeLength'] + 1)
                            ];
                        }
                    }
                }
            }
        }
        var_dump($seeds);
    }
}