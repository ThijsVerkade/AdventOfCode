<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day11;

use AdventOfCode\AbstractSolver;
use AdventOfCode\SolverInterface;

final class Solver extends AbstractSolver implements SolverInterface
{
    public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);
        $galaxies = [];
        $galaxyNumbers = [];
        $distances = [];
        $index = 0;
        foreach ($file as $row) {
            $galaxies[$index] = str_split($row);
            if (!str_contains($row, '#')) {
                $index++;
                $galaxies[$index] = str_split($row);
            }
            $index++;
        }
        $nums = [];
        for ($j = 0; $j < count($galaxies[0]); $j++) {
            $hasStar = false;
            for ($i = 0; $i < count($galaxies); $i++) {
                if ($galaxies[$i][$j] === '#') {
                    $hasStar = true;
                }
            }
            if (!$hasStar) {
                $nums[] = $j;
            }
        }
        $add = 0;
        foreach ($nums as $num) {
            for ($i = 0; $i < count($galaxies); $i++) {
                array_splice($galaxies[$i], $num + $add + 1, 0, ['0']);
            }
            $add++;
        }

        $start = 1;
        foreach ($galaxies as $index => $row) {
            foreach ($row as $galaxyIndex => $galaxy) {
                if ($galaxy === '#') {
                    $galaxyNumbers[$start] = [$index, $galaxyIndex];
                    $galaxies[$index][$galaxyIndex] = $start;
                    $start++;
                }
            }
        }
        foreach ($galaxies as $row) {
            echo PHP_EOL;
            foreach ($row as $item) {
                echo $item;
            }
        }


        foreach ($galaxyNumbers as $iX => $xGalaxyNumber) {
            foreach ($galaxyNumbers as $iY => $yGalaxyNumber) {
                if ($iX === $iY) {
                    continue;
                }
                if (isset($distances[$iX][$iY]) || isset($distances[$iY][$iX])) {
                    continue;
                }
                $distances[$iX][$iY][] = (
                    abs($galaxyNumbers[$iX][0] - $galaxyNumbers[$iY][0]) +
                    abs($galaxyNumbers[$iX][1] - $galaxyNumbers[$iY][1])
                );
            }
        }
        //8493415 - 8946873
        var_dump(count($distances));
        var_dump(447 * (447 - 1) / 2);
        $tot = 0;
        foreach ($distances as $distance) {
            foreach ($distance as $r) {
                foreach ($r as $s) {
                    $tot += $s;
                }
            }
        }
        var_dump($tot);
    }

    public function solutionTwo(): void
    {
        // TODO: Implement solutionTwo() method.
    }
}