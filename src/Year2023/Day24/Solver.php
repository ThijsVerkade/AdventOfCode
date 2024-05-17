<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day24;

use AdventOfCode\AbstractSolver;
use AdventOfCode\SolverInterface;
use Override;

final class Solver extends AbstractSolver implements SolverInterface
{
    #[Override] public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);

        foreach ($file as $row) {
            $rows = explode('@', $row);
            $positions = explode(',', trim($rows[0]));
            $velocity = explode(',', trim($rows[1]));

            $numbers[] = [
                'X1' => (int)$positions[0],
                'X2' => (int)$positions[0] + (int)$velocity[0],
                'Y1' => (int)$positions[1],
                'Y2' => (int)$positions[1] + (int)$velocity[1],
                'equation' => $this->findLineEquation(
                    (int)$positions[0],
                    (int)$positions[1],
                    (int)$positions[0] + (int)$velocity[0],
                    (int)$positions[1] + (int)$velocity[1]
                )
            ];
        }
        $solutions = [];
        foreach ($numbers as $key1 => $number1) {
            foreach ($numbers as $key2 => $number2) {
                if ($key1 === $key2 || isset($solutions[$key1 . $key2]) || isset($solutions[$key2 . $key1])) {
                    continue;
                }
                $solutions[$key1 . $key2] = $this->canLinesIntersect($number1, $number2);
            }
        }

        var_dump((array_filter($solutions, fn($solution) => $solution === true)));
    }

    private function findLineEquation(int $x1, int $y1, int $x2, int $y2): array
    {
        // Calculate slope
        $m = ($y2 - $y1) / ($x2 - $x1);

        // Use one of the points to find the equation
        $b = $y1 - $m * $x1;

        // Return equation in slope-intercept form (y = mx + b)
        return [
            'm' => $m,
            'b' => $b,
        ];
    }

    private function canLinesIntersect(array $number1, array $number2): bool
    {
        $m1 = $number1['equation']['m'];
        $b1 = $number1['equation']['b'];
        $m2 = $number2['equation']['m'];
        $b2 = $number2['equation']['b'];

        if ($m1 === $m2) {
            return $b1 === $b2;
        }
        $diffB = $b1 - $b2;
        if (!($diffB > 7 && $diffB < 28)) {
            return false;
        }

        $max_test_area = 27;
        $min_test_area = 7;

        $line1_start = [$b1 / $m1, 0];
        $line1_end = [($max_test_area - $b1) / $m1, $max_test_area];
        $line2_start = [$b2 / $m2, 0];
        $line2_end = [($max_test_area - $b2) / $m2, $max_test_area];

        $line1_distance = sqrt(($line1_end[0] - $line1_start[0]) ** 2 + ($line1_end[1] - $line1_start[1]) ** 2);
        $line2_distance = sqrt(($line2_end[0] - $line2_start[0]) ** 2 + ($line2_end[1] - $line2_start[1]) ** 2);

        return $line1_distance >= $min_test_area && $line1_distance <= $max_test_area && $line2_distance >= $min_test_area && $line2_distance <= $max_test_area;
    }

    #[Override] public function solutionTwo(): void
    {
        // TODO: Implement solutionTwo() method.
    }
}