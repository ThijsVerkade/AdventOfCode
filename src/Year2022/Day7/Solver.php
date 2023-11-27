<?php

declare(strict_types=1);

namespace Year2022\DaySeven;

use SolverInterface;

class Solver implements SolverInterface
{
    public function solutionOne(): void
    {
        $this->calculate();
    }

    public function calculate(): void
    {
        $myFile = file(__DIR__ . '/test_scenario_1.txt');

        $parent = '';
        $array[''] = [
            'amount' => 0,
            'parent' => '',
        ];

        foreach ($myFile as $key => $row) {
            $command = trim($row);
            $commandItems = explode(' ', $row);
            var_dump($commandItems);
            // check if cd .. -> new function
            // check if cd dir create function
            // check if ls add to amount
        }
    }


    public function addAmount(string $b, int $amount, array $array): int
    {
    }

    public function solutionTwo(): void
    {
        // TODO: Implement solutionTwo() method.
    }
}