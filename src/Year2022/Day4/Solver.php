<?php

declare(strict_types=1);

namespace Year2022\DayFour;

use SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        echo $this->formula();
    }

    private function formula($overlapAtAll = false): int
    {
        $file = file(__DIR__ . '/test_scenario_1.txt');

        $count = 0;

        foreach ($file as $row) {
            $row = trim($row);
            $assignedSections = explode(',', $row);

            $assignedSectionOne = explode('-', $assignedSections[0]);
            $assignedSectionTwo = explode('-', $assignedSections[1]);

            if (($assignedSectionOne[0] <= $assignedSectionTwo[0] &&
                    $assignedSectionOne[1] >= $assignedSectionTwo[1]) ||
                ($assignedSectionOne[0] >= $assignedSectionTwo[0] &&
                    $assignedSectionOne[1] <= $assignedSectionTwo[1]) ||
                (
                    (
                        ($assignedSectionOne[0] <= $assignedSectionTwo[0] &&
                            $assignedSectionOne[1] >= $assignedSectionTwo[0]) ||
                        ($assignedSectionOne[0] <= $assignedSectionTwo[1] &&
                            $assignedSectionOne[1] >= $assignedSectionTwo[1])
                    )
                    && $overlapAtAll
                )
            ) {
                $count++;
            }
        }

        return $count;
    }

    public function solutionTwo(): void
    {
        echo $this->formula(true);
    }
}