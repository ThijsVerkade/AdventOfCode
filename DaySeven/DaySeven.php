<?php

declare(strict_types=1);

namespace Day;

use Day;

class DaySeven implements Day
{
    public function solutionOne(): void
    {
        $this->calculate();
    }

    public function calculate(): void
    {
        $myFile = file(__DIR__ . '/day_seven.txt');

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