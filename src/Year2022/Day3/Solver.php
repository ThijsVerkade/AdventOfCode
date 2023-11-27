<?php

declare(strict_types=1);

namespace Year2022\DayThree;

use SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        echo $this->calculate();
    }

    public function calculate(): int
    {
        $file = file(__DIR__ . '/test_scenario_1.txt');

        $alphabetLower = range('a', 'z');
        $alphabetUpper = range('A', 'Z');

        $total = 0;

        foreach ($file as $row) {
            $string = trim($row);
            $ruckSacks = str_split($string, strlen($string) / 2);
            $totalSack = 0;
            foreach (str_split($ruckSacks[0]) as $sack) {
                if (str_contains($ruckSacks[1], $sack)) {
                    if (!array_search($sack, $alphabetLower)) {
                        $s = array_search($sack, $alphabetUpper) + 27;
                    } else {
                        $s = array_search($sack, $alphabetLower) + 1;
                    }
                    if ($s > $totalSack) {
                        $totalSack = $s;
                    }
                }
            }
            $total += $totalSack;
        }


        $total2 = 0;

        foreach ($file as $key => $row) {
            if ($key % 3 !== 0) {
                continue;
            }
            $ruckSackOne = trim($row);
            $ruckSackTwo = trim($file[$key + 1]);
            $ruckSackThree = trim($file[$key + 2]);
            $totalSack = 0;

            foreach (str_split($ruckSackOne) as $sack) {
                if (str_contains($ruckSackTwo, $sack) && str_contains($ruckSackThree, $sack)) {
                    if (!array_search($sack, $alphabetLower)) {
                        $s = array_search($sack, $alphabetUpper) + 27;
                    } else {
                        $s = array_search($sack, $alphabetLower) + 1;
                    }
                    if ($s > $totalSack) {
                        $totalSack = $s;
                    }
                }
            }

            $total2 += $totalSack;
        }

        return $total2;
    }

    public function solutionTwo(): void
    {
    }
}