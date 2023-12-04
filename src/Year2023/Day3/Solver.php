<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day3;

use AdventOfCode\AbstractSolver;
use AdventOfCode\Enums\Scenario;
use AdventOfCode\SolverInterface;

final class Solver extends AbstractSolver implements SolverInterface
{

    public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);

        $scheme = [];
        foreach ($file as $index => $row) {
            $scheme[$index] = array_filter(str_split($row), fn($value) => trim($value) !== '');
        }

        $total = 0;

        $validNumber = false;
        $partNumbers = '';

        foreach ($scheme as $indexRow => $row) {
            echo PHP_EOL;
            if ($validNumber) {
                $total += (int)$partNumbers;
            }
            $validNumber = false;
            $partNumbers = '';
            foreach ($row as $indexItem => $item) {
                if (!is_numeric($item)) {
                    if ($validNumber) {
                        $total += (int)$partNumbers;
                    }
                    if ($item !== '.') {
                        echo "\033[33m$item\033[0m";
                    } else {
                        echo $item;
                    }
                    $validNumber = false;
                    $partNumbers = '';
                    continue;
                }

                $partNumbers .= $item;

                $bottom = $scheme[$indexRow + 1][$indexItem] ?? '.';
                $top = $scheme[$indexRow - 1][$indexItem] ?? '.';
                $left = $row[$indexItem - 1] ?? '.';
                $right = $row[$indexItem + 1] ?? '.';
                $topRight = $scheme[$indexRow - 1][$indexItem + 1] ?? '.';
                $topLeft = $scheme[$indexRow - 1][$indexItem - 1] ?? '.';
                $bottomRight = $scheme[$indexRow + 1][$indexItem + 1] ?? '.';
                $bottomLeft = $scheme[$indexRow + 1][$indexItem - 1] ?? '.';

                if (
                    (!is_numeric($bottom) && $bottom !== '.') ||
                    (!is_numeric($top) && $top !== '.') ||
                    (!is_numeric($left) && $left !== '.') ||
                    (!is_numeric($right) && $right !== '.') ||
                    (!is_numeric($topRight) && $topRight !== '.') ||
                    (!is_numeric($topLeft) && $topLeft !== '.') ||
                    (!is_numeric($bottomRight) && $bottomRight !== '.') ||
                    (!is_numeric($bottomLeft) && $bottomLeft !== '.')
                ) {
                    echo "\033[31m$item\033[0m";
                    $validNumber = true;
                } else {
                    echo $item;
                }
            }
        }
        echo PHP_EOL . "\033[32m$total\033[0m";
    }

    public function solutionTwo(): void
    {
        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);

        $scheme = [];
        foreach ($file as $index => $row) {
            $scheme[$index] = array_filter(str_split($row), fn($value) => trim($value) !== '');
        }

        $validNumber = false;
        $partNumber = '';
        $gearRatios = [];
        $aindex = [];
        $items = [];

        foreach ($scheme as $indexRow => $row) {
            echo PHP_EOL;
            if ($validNumber) {
                foreach ($aindex as $b) {
                    $items[$indexRow - 1][$b] = $partNumber;
                }
            }
            $aindex = [];
            $validNumber = false;
            $partNumber = '';
            foreach ($row as $indexItem => $item) {
                if (!is_numeric($item)) {
                    if ($validNumber) {
                        foreach ($aindex as $b) {
                            $items[$indexRow][$b] = $partNumber;
                        }
                    }
                    if ($item !== '.') {
                        echo "\033[33m$item\033[0m";
                    } else {
                        echo $item;
                    }
                    $validNumber = false;
                    $partNumber = '';
                    $aindex = [];
                    continue;
                }
                $aindex[] = $indexItem;
                $partNumber .= $item;
                $options = [
                    'bottom' => [
                        'indexRow' => $indexRow + 1,
                        'indexItem' => $indexItem,
                    ],
                    'top' => [
                        'indexRow' => $indexRow - 1,
                        'indexItem' => $indexItem,
                    ],
                    'left' => [
                        'indexRow' => $indexRow,
                        'indexItem' => $indexItem - 1,
                    ],
                    'right' => [
                        'indexRow' => $indexRow,
                        'indexItem' => $indexItem + 1,
                    ],
                    'topRight' => [
                        'indexRow' => $indexRow - 1,
                        'indexItem' => $indexItem + 1,
                    ],
                    'topLeft' => [
                        'indexRow' => $indexRow - 1,
                        'indexItem' => $indexItem - 1,
                    ],
                    'bottomRight' => [
                        'indexRow' => $indexRow + 1,
                        'indexItem' => $indexItem + 1,
                    ],
                    'bottomLeft' => [
                        'indexRow' => $indexRow + 1,
                        'indexItem' => $indexItem - 1,
                    ],
                ];
                $showItem = true;
                foreach ($options as $option) {
                    $operator = $scheme[$option['indexRow']][$option['indexItem']] ?? '.';
                    if (!is_numeric($operator) && $operator !== '.') {
                        $validNumber = true;
                        if ($operator === '*') {
                            $gearRatios[$option['indexRow']][$option['indexItem']][] = [$indexRow, $indexItem];
                            if ($showItem) {
                                echo "\033[34m$item\033[0m";
                            }
                        } elseif ($showItem) {
                            echo "\033[31m$item\033[0m";
                        }

                        $showItem = false;
                    }
                }
                if ($showItem) {
                    echo $item;
                }
            }
        }
        $total = 0;
        foreach ($gearRatios as $gearRatio) {
            foreach ($gearRatio as $numbers) {
                if (count($numbers) < 2) {
                    continue;
                }
                $first = null;
                $second = null;
                foreach ($numbers as $number) {
                    if ($first === null) {
                        $first = $items[$number[0]][$number[1]];
                        continue;
                    }
                    if ($first !== $items[$number[0]][$number[1]]) {
                        $second = $items[$number[0]][$number[1]];
                    }
                }

                if ($first === null || $second === null) {
                    continue;
                }

                $total += (int)$first * (int)$second;
            }
        }
        echo PHP_EOL . "\033[32m$total\033[0m";
    }
}