<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day7;

use AdventOfCode\AbstractSolver;
use AdventOfCode\Enums\Scenario;
use AdventOfCode\SolverInterface;

final class Solver extends AbstractSolver implements SolverInterface
{
    public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);

        $total = [
            'five-of-a-kind' => [],
            'four-of-a-kind' => [],
            'full-house' => [],
            'three-of-a-kind' => [],
            'two-pair' => [],
            'one-pair' => [],
            'high-card' => [],
        ];

        $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];

        foreach ($file as $row) {
            $hand = explode(' ', trim($row));
            $doubleChars = count_chars($hand[0], 1);
            $countDoubles = array_count_values($doubleChars);

            $key = match (true) {
                in_array(5, $doubleChars, true) => 'five-of-a-kind',
                in_array(4, $doubleChars, true) => 'four-of-a-kind',
                in_array(3, $doubleChars, true) &&
                in_array(2, $doubleChars, true) => 'full-house',
                in_array(3, $doubleChars, true) => 'three-of-a-kind',
                in_array(2, $doubleChars, true) &&
                array_search(2, $countDoubles, true) === 2 => 'two-pair',
                in_array(2, $doubleChars, true) => 'one-pair',
                default => 'high-card',
            };

            $handRank = '';
            foreach (str_split($hand[0]) as $card) {
                $rank = array_search($card, $ranks, true);

                $handRank .= (strlen((string)$rank) !== 2 ? '0' : '') . $rank;
            }
            $total[$key][$handRank] = $hand;
            ksort($total[$key]);
        }

        $rank = 1;
        $points = 0;
        foreach (
            [
                'high-card',
                'one-pair',
                'two-pair',
                'three-of-a-kind',
                'full-house',
                'four-of-a-kind',
                'five-of-a-kind',
            ] as $cardsKey
        ) {
            ksort($total[$cardsKey]);
            foreach ($total[$cardsKey] as $card) {
                $points += $rank * (int)$card[1];
                $rank++;
            }
        }
        echo $points;
    }

    public function solutionTwo(): void
    {
        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);

        $total = [
            'five-of-a-kind' => [],
            'four-of-a-kind' => [],
            'full-house' => [],
            'three-of-a-kind' => [],
            'two-pair' => [],
            'one-pair' => [],
            'high-card' => [],
        ];
        $ranks = ['J', '2', '3', '4', '5', '6', '7', '8', '9', 'T', 'Q', 'K', 'A'];

        foreach ($file as $row) {
            $hand = explode(' ', trim($row));

            $doubleChars = count_chars($hand[0], 1);
            $tempHand = $hand[0];
            if (str_contains($hand[0], 'J')) {
                foreach (array_keys($doubleChars, max($doubleChars)) as $doubleChar) {
                    $character = chr($doubleChar);
                    if ($character === 'J') {
                        continue;
                    }
                    $tempHand = str_replace('J', $character, $hand[0]);
                    break;
                }
                if (str_contains($tempHand, 'J')) {
                    $filteredChars = array_values(
                        array_filter(str_split($tempHand), fn(string $char) => $char !== 'J')
                    );

                    if (count($filteredChars) > 0) {
                        $tempHand = str_replace('J', $filteredChars[0], $tempHand);
                    }
                }
            }

            $doubleChars = count_chars($tempHand, 1);
            $countDoubles = array_count_values($doubleChars);

            $key = match (true) {
                in_array(5, $doubleChars, true) => 'five-of-a-kind',
                in_array(4, $doubleChars, true) => 'four-of-a-kind',
                in_array(3, $doubleChars, true) &&
                in_array(2, $doubleChars, true) => 'full-house',
                in_array(3, $doubleChars, true) => 'three-of-a-kind',
                in_array(2, $doubleChars, true) &&
                array_search(2, $countDoubles, true) === 2 => 'two-pair',
                in_array(2, $doubleChars, true) => 'one-pair',
                default => 'high-card',
            };

            $handRank = '';
            foreach (str_split($hand[0]) as $card) {
                $rank = array_search($card, $ranks, true);

                $handRank .= (strlen((string)$rank) !== 2 ? '0' : '') . $rank;
            }
            $total[$key][$handRank] = $hand;
            ksort($total[$key]);
        }
        $rank = 1;
        $points = 0;
        foreach (
            [
                'high-card',
                'one-pair',
                'two-pair',
                'three-of-a-kind',
                'full-house',
                'four-of-a-kind',
                'five-of-a-kind',
            ] as $cardsKey
        ) {
            ksort($total[$cardsKey]);
            foreach ($total[$cardsKey] as $card) {
                echo $card[0] . ' - ' . $card[1];
                echo PHP_EOL;
                $points += $rank * (int)$card[1];
                $rank++;
            }
        }

        echo $points;
    }
}