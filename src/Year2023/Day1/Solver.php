<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day1;

use AdventOfCode\AbstractSolver;
use AdventOfCode\Enums\Scenario;
use AdventOfCode\SolverInterface;

final class Solver extends AbstractSolver implements SolverInterface
{
    public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);
        $total = 0;
        foreach ($file as $row) {
            $total += $this->calculate($row);
        }
        echo $total;
    }

    private function calculate(string $row): int
    {
        preg_match_all('/[0-9]/', $row, $values);

        $firstNumber = current($values[0]);
        $lastNumber = end($values[0]);

        return (int)($firstNumber . $lastNumber);
    }

    public function solutionTwo(): void
    {
        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);
        $digitNames = ["one", "two", "three", "four", "five", "six", "seven", "eight", "nine"];

        $total = 0;
        foreach ($file as $row) {
            foreach ($digitNames as $digitName) {
                if (str_contains($row, $digitName)) {
                    $row = str_replace(
                        $digitName,
                        $digitName . $this->digitNameToNumber($digitName) . $digitName,
                        $row
                    );
                }
            }
            $total += $this->calculate($row);
        }
        echo $total;
    }

    private function digitNameToNumber(string $digitName): int
    {
        return match ($digitName) {
            'one' => 1,
            'two' => 2,
            'three' => 3,
            'four' => 4,
            'five' => 5,
            'six' => 6,
            'seven' => 7,
            'eight' => 8,
            'nine' => 9
        };
    }
}