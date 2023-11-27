<?php

declare(strict_types=1);

namespace Day;

use Day;

class DayOne implements Day
{
    private function formula(): array
    {
        $fh = file(__DIR__.'/day_one.txt');

        $total = 0;
        $temp = 0;
        $array = [];

        foreach ($fh as $key => $item) {
            $value = trim($item);

            if ($value === '') {
                if ($temp > $total) {
                    $total = $temp;
                }
                $array[$key] = $temp;
                $temp = 0;
                continue;
            }

            $temp = $temp + (int)$item;
        }

        return [
            'total' => $total,
            'array' => $array,
        ];
    }


    public function solutionOne(): void
    {
        echo $this->formula()['total'];
    }

    public function solutionTwo(): void
    {
        $array = $this->formula()['array'];

        echo array_sum(array_slice($array, -3, 3, true));
    }
}