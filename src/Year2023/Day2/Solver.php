<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day2;

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
            $games = explode(';', end($row));
            $validGame = true;

            foreach ($games as $game) {
                $green = 0;
                $red = 0;
                $blue = 0;

                foreach (explode(',', $game) as $cube) {
                    $amount = filter_var($cube, FILTER_SANITIZE_NUMBER_INT);
                    switch (true) {
                        case str_contains($cube, 'green'):
                            $green += $amount;
                            break;
                        case str_contains($cube, 'red'):
                            $red += $amount;
                            break;
                        case str_contains($cube, 'blue'):
                            $blue += $amount;
                            break;
                    }
                }

                if ($green > 13 || $red > 12 || $blue > 14) {
                    $validGame = false;
                }
            }

            if ($validGame) {
                $total += filter_var($row[0], FILTER_SANITIZE_NUMBER_INT);
            }
        }

        echo $total;
    }

    public function solutionTwo(): void
    {
        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);

        $total = 0;

        foreach ($file as $row) {
            $row = explode(':', $row);

            $games = str_replace(';', ',', end($row));
            $games = explode(',', $games);

            $red = 0;
            $blue = 0;
            $green = 0;

            foreach ($games as $cube) {
                $amount = filter_var($cube, FILTER_SANITIZE_NUMBER_INT);
                switch (true) {
                    case str_contains($cube, 'green'):
                        $green = max($green, $amount);
                        break;
                    case str_contains($cube, 'red'):
                        $red = max($red, $amount);
                        break;
                    case str_contains($cube, 'blue'):
                        $blue = max($blue, $amount);
                        break;
                }
            }

            $total += $green * $red * $blue;
        }

        echo $total;
    }
}