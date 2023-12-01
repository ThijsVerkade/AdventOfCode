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
            $firstNumber = null;
            $lastNumber = null;
            foreach (str_split($row) as $item) {
                if (is_numeric($item)) {
                    if (is_null($firstNumber)) {
                        $firstNumber = $item;
                    }
                    $lastNumber = $item;
                }
            }
            $total += (int)($firstNumber . $lastNumber);
        }
        echo $total;
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

    private function calculate(string $row): int
    {
        $firstNumber = null;
        $lastNumber = null;
        foreach (str_split($row) as $item) {
            if (is_numeric($item)) {
                if (is_null($firstNumber)) {
                    $firstNumber = $item;
                }
                $lastNumber = $item;
            }
        }
        return (int)($firstNumber . $lastNumber);
    }
}