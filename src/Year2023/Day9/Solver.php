<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day9;

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
            $numbers = explode(' ', $row);
            $numbersLists = [];
            while (count(array_filter($numbers)) > 0) {
                $oldNumber = null;
                $numberRows = [];
                $numbersLists[] = $numbers;
                foreach ($numbers as $number) {
                    if ($oldNumber !== null) {
                        $numberRows[] = $number - $oldNumber;
                    }
                    $oldNumber = $number;
                }
                $numbers = $numberRows;
            }
            krsort($numbersLists);
            $add = 0;
            foreach ($numbersLists as $numbersList) {
                $add += end($numbersList);
            }
            $total += $add;
        }
        echo $total;
    }

    public function solutionTwo(): void
    {
        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);
        $total = 0;
        foreach ($file as $row) {
            $numbers = explode(' ', $row);
            $numbersLists = [];
            while (count(array_filter($numbers)) > 0) {
                $oldNumber = null;
                $numberRows = [];
                $numbersLists[] = $numbers;
                foreach ($numbers as $number) {
                    if ($oldNumber !== null) {
                        $numberRows[] = $number - $oldNumber;
                    }
                    $oldNumber = $number;
                }
                $numbers = $numberRows;
            }
            krsort($numbersLists);
            $add = 0;
            foreach ($numbersLists as $numbersList) {
                $add = reset($numbersList) - $add;
            }

            $total += $add;
        }
        echo $total;
    }
}