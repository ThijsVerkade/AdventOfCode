<?php

declare(strict_types=1);

namespace AdventOfCode\Year2022\Day10;

use AdventOfCode\SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        $myFile = file(__DIR__ . '/test_scenario_1.txt');
        $cycle = 1;
        $instruction = 1;
        $total = 0;

        foreach ($myFile as $row) {
            $signal = explode(' ', $row);
            if (str_contains($row, 'addx')) {
                $cycle += 1;
                if ($cycle == 20 || (($cycle - 20) % 40 == 0)) {
                    $total += $cycle * $instruction;
                }
                var_dump($cycle);
                var_dump($signal[1]);
                $instruction += (int)$signal[1];
                $cycle += 1;
            } else {
                $cycle += 1;
            }
            if ($cycle == 20 || (($cycle - 20) % 40 == 0)) {
                $total += $cycle * $instruction;
            }
        }

        var_dump($total);
    }

    public function solutionTwo(): void
    {
        // TODO: Implement solutionTwo() method.
    }
}