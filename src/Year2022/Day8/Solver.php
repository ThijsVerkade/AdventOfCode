<?php

declare(strict_types=1);

namespace AdventOfCode\Year2022\Day8;

use AdventOfCode\SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        $this->calculate();
    }

    private function calculate(): void
    {
        $file = file(__DIR__ . '/test_scenario_1.txt');

        $array = [];
        foreach ($file as $k => $row) {
            foreach (str_split(trim($row)) as $key => $item) {
                $array[$k][$key] = $item;
            }
        }
        $total = count($array) * 4 - 4;
        $subTotal = 0;
        $totalVisibleThrees = 0;

        foreach ($array as $key => $a) {
            echo PHP_EOL;
            if ($key > 0 && $key < count($a) - 1) {
                foreach ($a as $key1 => $b) {
                    $topBottom = [];
                    for ($x = 0; $x < $key; $x++) {
                        $topBottom[] = $array[$x][$key1];
                    }
                    $bottomTop = [];

                    for ($x = 0; $x < count($array[$x]) - $key - 1; $x++) {
                        $bottomTop[] = $array[count($array[$x]) - $x - 1][$key1];
                    }
                    $leftRight = [];
                    for ($x = 0; $x < $key1; $x++) {
                        $leftRight[] = $array[$key][$x];
                    }
                    $rightLeft = [];

                    for ($x = 0; $x < count($array[$key]) - $key1 - 1; $x++) {
                        $rightLeft[] = $array[$key][count($array[$key]) - $x - 1];
                    }
                    if ($key1 > 0 && $key1 < count($a) - 1) {
                        if (
                            $this->visibleThree((int)$b, $leftRight) ||
                            $this->visibleThree((int)$b, $topBottom) ||
                            $this->visibleThree((int)$b, $bottomTop) ||
                            $this->visibleThree((int)$b, $rightLeft)
                        ) {
                            echo "*" . ($b);
                            $total += 1;
                        }
                        $visibleThrees = $this->countVisibleThrees((int)$b, $leftRight) *
                            $this->countVisibleThrees((int)$b, $topBottom) *
                            $this->countVisibleThrees((int)$b, $bottomTop) *
                            $this->countVisibleThrees((int)$b, $rightLeft);

                        if ($totalVisibleThrees < $visibleThrees) {
                            $totalVisibleThrees = $visibleThrees;
                        }
                    }
                }
            }
        }
//        var_dump($total);
        var_dump($totalVisibleThrees);
    }

    private function visibleThree(int $tree, array $leftRight): bool
    {
        foreach ($leftRight as $item) {
            if ($item >= $tree) {
                return false;
            }
        }

        return true;
    }

    public function countVisibleThrees(int $tree, array $leftRight): int
    {
        $count = 0;
        foreach (array_reverse($leftRight) as $item) {
            $count++;
            if ($item >= $tree) {
                break;
            }
        }

        return $count;
    }

    public function solutionTwo(): void
    {
        // TODO: Implement solutionTwo() method.
    }
}