<?php

declare(strict_types=1);

namespace Year2022\DayTwo;

use SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        echo $this->formula()['ownScore'];
    }

    private function formula(): array
    {
        $strategyGuide = [
            'Y' => [ // Draw
                'A' => 'X',
                'B' => 'Y',
                'C' => 'Z',
            ],
            'X' => [ // Lose
                'A' => 'Z',
                'B' => 'X',
                'C' => 'Y',
            ],
            'Z' => [ // Winning
                'A' => 'Y',
                'B' => 'Z',
                'C' => 'X',
            ],
        ];

        $fh = file(__DIR__ . '/test_scenario_1.txt');

        $shapeScore = [
            'A' => 1, //Rock
            'X' => 1, //Rock
            'B' => 2, //Paper
            'Y' => 2, //Paper
            'C' => 3, //Scissors
            'Z' => 3, //Scissors
        ];

        $opponentScore = 0;
        $ownScore = 0;

        $strategyGuideScore = 0;

        foreach ($fh as $key => $item) {
            $opponentInput = trim($item)[0];
            $ownInput = trim($item)[2];
            $strategyGuideInput = $strategyGuide[$ownInput][$opponentInput];

            $opponentScore += $shapeScore[$opponentInput];
            $ownScore += $shapeScore[$ownInput];
            $strategyGuideScore += $shapeScore[$strategyGuideInput];

            $ownScore += $this->calculateWinningPoints($opponentInput, $ownInput);
            $strategyGuideScore += $this->calculateWinningPoints($opponentInput, $strategyGuideInput);
        }

        return [
            'opponentScore' => $opponentScore,
            'ownScore' => $ownScore,
            'strategyGuideScore' => $strategyGuideScore,
        ];
    }

    private function calculateWinningPoints(string $opponentInput, string $ownInput): int
    {
        $match = $opponentInput . $ownInput;
        if ($match === 'BY' || $match === 'CZ' || $match === 'AX') {
            // paper(B) => paper(Y) = equal
            // scissors(C) => scissor(Z) = equal
            // rock(A) => rock(X) = equal
            return 3;
        } elseif ($match === 'BZ' || $match === 'CX' || $match === 'AY') {
            // paper(B) => scissor(Z) = scissor
            // scissors(C) => rock(X) = rock
            // rock(A) => paper(Y) = paper
            return 6;
        }

        // paper(B) => rock(X) = paper
        // scissor(C) => paper(Y) = scissor
        // rock(A) => scissors(Z) = rock
        return 0;
    }

    public function solutionTwo(): void
    {
        echo $this->formula()['strategyGuideScore'];
    }

}