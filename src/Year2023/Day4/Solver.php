<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day4;

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
            $row = explode(':', $row);
            $game = explode('|', $row[1]);
            $winningNumbers = explode(' ', $game[0]);
            $numbers = explode(' ', $game[1]);
            $subTotal = 0;
            foreach ($numbers as $number) {
                if ($number === '') {
                    continue;
                }

                if (in_array(trim($number), $winningNumbers, true)) {
                    if ($subTotal === 0) {
                        ++$subTotal;
                    } else {
                        $subTotal *= 2;
                    }
                }
            }

            $total += $subTotal;
        }
        echo $total;
    }

    public function solutionTwo(): void
    {
        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);

        $scratchcards = [];
        foreach ($file as $row) {
            $row = explode(':', $row);
            $card = trim(str_replace('Card', '', $row[0]));
            $scratchcards[$card] = 1;
        }

        foreach ($file as $row) {
            $row = explode(':', $row);
            $card = trim(str_replace('Card', '', $row[0]));
            $game = explode('|', $row[1]);
            $winningNumbers = explode(' ', $game[0]);
            $numbers = explode(' ', $game[1]);


            $subTotal = $card;
            $amountOfCards = $scratchcards[$subTotal];
            foreach ($numbers as $number) {
                if ($number === '') {
                    continue;
                }

                if (in_array(trim($number), $winningNumbers, true)) {
                    $subTotal++;
                    $scratchcards[$subTotal] += $amountOfCards * 1;
                }
            }
        }

        $total = 0;
        foreach ($scratchcards as $scratchcard) {
            $total += $scratchcard;
        }
        echo $total;
    }
}