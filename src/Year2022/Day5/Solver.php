<?php

declare(strict_types=1);

namespace AdventOfCode\Year2022\Day5;

use AdventOfCode\SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        $this->formula();
    }

    private function formula($mulitpleCrates = false): string
    {
        $file = file(__DIR__ . '/test_scenario_1.txt');

        $stackItems = [
            1 => 1,
            2 => 5,
            3 => 9,
            4 => 13,
            5 => 17,
            6 => 21,
            7 => 25,
            8 => 29,
            9 => 33,
        ];

        foreach ($file as $key => $row) {
            if (!str_contains($row, 'move') && str_contains($row, '[')) {
                foreach ($stackItems as $index => $item) {
                    if (isset($row[$item]) && $row[$item] !== ' ') {
                        $stacks[$index][$key] = $row[$item];
                    }
                }
            }

            if (str_contains($row, 'move')) {
                preg_match_all('!\d+!', $row, $matches);
                $array = [];
                for ($x = 0; $x < $matches[0][0]; $x += 1) {
                    if ($matches[0][0] > 1 && $mulitpleCrates) {
                        $array[] = $stacks[$matches[0][1]][$x];
                    } else {
                        array_unshift($stacks[$matches[0][2]], $stacks[$matches[0][1]][$x]);
                    }
                }
                if ($matches[0][0] > 1 && $mulitpleCrates) {
                    foreach (array_reverse($array) as $item) {
                        array_unshift($stacks[$matches[0][2]], $item);
                    }
                }
                $stacks[$matches[0][1]] = array_slice($stacks[$matches[0][1]], (int)$matches[0][0]);
            }
        }

        $output = '';
        foreach ($stackItems as $index => $item) {
            if (isset($stacks[$index][0])) {
                $output = $output . $stacks[$index][0];
            }
        }

        return $output;
    }

    public function solutionTwo(): void
    {
        echo $this->formula(true);
    }
}