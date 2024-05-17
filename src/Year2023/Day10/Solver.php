<?php

declare(strict_types=1);

namespace AdventOfCode\Year2023\Day10;

use AdventOfCode\AbstractSolver;
use AdventOfCode\Enums\Scenario;
use AdventOfCode\SolverInterface;

final class Solver extends AbstractSolver implements SolverInterface
{
    public function solutionOne(): void
    {
        $file = $this->getTestScenario(__DIR__);
        $maze = [];
        $startingPointX = null;
        $startingPointY = null;

        foreach ($file as $row) {
            $currentRow = str_split($row);
            $maze[] = $currentRow;
            $findStartingPoint = array_search('S', $currentRow, true);

            if ($findStartingPoint !== false) {
                $startingPointX = $findStartingPoint;
                $startingPointY = count($maze) - 1;
            }
        }

        $options = [
            'bottom' => [
                'indexRow' => 1,
                'indexItem' => 0,
            ],
            'top' => [
                'indexRow' => -1,
                'indexItem' => 0,
            ],
            'left' => [
                'indexRow' => 0,
                'indexItem' => -1,
            ],
            'right' => [
                'indexRow' => 0,
                'indexItem' => 1,
            ],
        ];

        $startPoints = [];
        foreach ($options as $key => $option) {
            $value = $maze[$startingPointY + $option['indexRow']][$startingPointX + $option['indexItem']] ?? '.';
            if ($value === '.') {
                continue;
            }

            if (
                ($value === 'J' && ($key === 'right' || $key === 'bottom')) ||
                ($value === 'L' && ($key === 'left' || $key === 'bottom')) ||
                ($value === '7' && ($key === 'left' || $key === 'top')) ||
                ($value === 'F' && ($key === 'right' || $key === 'top')) ||
                ($value === '|' && ($key === 'bottom' || $key === 'top')) ||
                ($value === '-' && ($key === 'left' || $key === 'right'))
            ) {
                $startPoints[] = [
                    'y' => $startingPointY + $option['indexRow'],
                    'x' => $startingPointX + $option['indexItem'],
                    'key' => $key,
                ];
            }
        }
        $p = [];
        foreach ($startPoints as $startPoint) {
            $startingPointY = $startPoint['y'];
            $startingPointX = $startPoint['x'];
            $start = true;
            $paths = [];
            $key = $startPoint['key'];
            while ($start) {
                $paths[] = [
                    'x' => $startingPointX,
                    'y' => $startingPointY,
                ];
                $value = $maze[$startingPointY][$startingPointX];

                if ($value === 'S') {
                    $start = false;
                    continue;
                }
                if ($value === '.') {
                    continue;
                }

                if ($value === 'L') {
                    if ($key === 'bottom') {
                        $key = 'right';
                    } elseif ($key === 'left') {
                        $key = 'top';
                    }
                } elseif ($value === 'J') {
                    if ($key === 'bottom') {
                        $key = 'left';
                    } elseif ($key === 'right') {
                        $key = 'top';
                    }
                } elseif ($value === '7') {
                    if ($key === 'top') {
                        $key = 'left';
                    } elseif ($key === 'right') {
                        $key = 'bottom';
                    }
                } elseif ($value === 'F') {
                    if ($key === 'top') {
                        $key = 'right';
                    } elseif ($key === 'left') {
                        $key = 'bottom';
                    }
                }
                $option = $options[$key];
                $startingPointY += $option['indexRow'];
                $startingPointX += $option['indexItem'];
            }

            $p[] = $paths;
        }
        echo PHP_EOL;

        foreach ($maze as $indexRow => $row) {
            echo PHP_EOL;
            foreach ($row as $indexItem => $item) {
                if (in_array(['y' => $indexRow, 'x' => $indexItem], $p[0])) {
                    $item = match ($item) {
                        'L' => '╚',
                        'J' => '╝',
                        'F' => '╔',
                        '7' => '╗',
                        '|' => '║',
                        '-' => '═',
                        'S' => '■'
                    };
                    if ($item === 'L') {
                        $item = '└';
                    }

                    echo "\033[34m$item\033[0m";
                } else {
                    echo $item;
                }
            }
        }

        foreach ($p as $s) {
            var_dump((count($s)) / 2);
        }
    }

    public function solutionTwo(): void
    {
        $file = $this->getTestScenario(__DIR__, Scenario::testScenario2);
        $maze = [];
        $startingPointX = null;
        $startingPointY = null;
        $mazePoly = [];
        foreach ($file as $rowIndex => $row) {
            $currentRow = str_split($row);
            $maze[] = $currentRow;
            $findStartingPoint = array_search('S', $currentRow, true);
            foreach ($currentRow as $itemIndex => $item) {
                $mazePoly[] = [$rowIndex, $itemIndex];
            }

            if ($findStartingPoint !== false) {
                $startingPointX = $findStartingPoint;
                $startingPointY = count($maze) - 1;
            }
        }

        $options = [
            'bottom' => [
                'indexRow' => 1,
                'indexItem' => 0,
            ],
            'top' => [
                'indexRow' => -1,
                'indexItem' => 0,
            ],
            'left' => [
                'indexRow' => 0,
                'indexItem' => -1,
            ],
            'right' => [
                'indexRow' => 0,
                'indexItem' => 1,
            ],
        ];
        $enclosed = $maze;
        $startPoints = [];
        foreach ($options as $key => $option) {
            $value = $maze[$startingPointY + $option['indexRow']][$startingPointX + $option['indexItem']] ?? '.';
            if ($value === '.') {
                continue;
            }

            if (
                ($value === 'J' && ($key === 'right' || $key === 'bottom')) ||
                ($value === 'L' && ($key === 'left' || $key === 'bottom')) ||
                ($value === '7' && ($key === 'left' || $key === 'top')) ||
                ($value === 'F' && ($key === 'right' || $key === 'top')) ||
                ($value === '|' && ($key === 'bottom' || $key === 'top')) ||
                ($value === '-' && ($key === 'left' || $key === 'right'))
            ) {
                $points[] = [$startingPointX + $option['indexItem'], $startingPointY + $option['indexRow']];
                $startPoints[] = [
                    'y' => $startingPointY + $option['indexRow'],
                    'x' => $startingPointX + $option['indexItem'],
                    'key' => $key,
                ];
            }
        }
        $p = [];
        foreach ($startPoints as $startPoint) {
            $startingPointY = $startPoint['y'];
            $startingPointX = $startPoint['x'];
            $start = true;
            $paths = [];
            $key = $startPoint['key'];
            while ($start) {
                unset($enclosed[$startingPointY][$startingPointX]);
                $paths[] = [
                    'x' => $startingPointX,
                    'y' => $startingPointY,
                ];
                $value = $maze[$startingPointY][$startingPointX];

                if ($value === 'S') {
                    $start = false;
                    continue;
                }
                if ($value === '.') {
                    continue;
                }

                if ($value === 'L') {
                    if ($key === 'bottom') {
                        $key = 'right';
                    } elseif ($key === 'left') {
                        $key = 'top';
                    }
                } elseif ($value === 'J') {
                    if ($key === 'bottom') {
                        $key = 'left';
                    } elseif ($key === 'right') {
                        $key = 'top';
                    }
                } elseif ($value === '7') {
                    if ($key === 'top') {
                        $key = 'left';
                    } elseif ($key === 'right') {
                        $key = 'bottom';
                    }
                } elseif ($value === 'F') {
                    if ($key === 'top') {
                        $key = 'right';
                    } elseif ($key === 'left') {
                        $key = 'bottom';
                    }
                }
                $option = $options[$key];
                $startingPointY += $option['indexRow'];
                $startingPointX += $option['indexItem'];
            }

            $p[] = $paths;
        }
        echo PHP_EOL;

        foreach ($maze as $indexRow => $row) {
            echo PHP_EOL;
            foreach ($row as $indexItem => $item) {
                if (in_array(['y' => $indexRow, 'x' => $indexItem], $p[0])) {
                    $item = match ($item) {
                        'L' => '╚',
                        'J' => '╝',
                        'F' => '╔',
                        '7' => '╗',
                        '|' => '║',
                        '-' => '═',
                        'S' => '■'
                    };
                    if ($item === 'L') {
                        $item = '└';
                    }

                    echo "\033[34m$item\033[0m";
                } else {
                    if ($this->isPointInPolygon([$indexRow, $indexItem], $points)) {
                        echo "\033[32m$item\033[0m - ";
                    } else {
                        echo $item;
                    }
                }
            }
        }

//        var_dump($this->isPointInPolygon([], $points));

//        foreach ($p as $s) {
//            var_dump((count($s)) / 2);
//        }
    }

    public function isPointInPolygon($point, $polygon)
    {
        $x = $point[0];
        $y = $point[1];
        $inside = false;

        $count = count($polygon);
        for ($i = 0, $j = $count - 1; $i < $count; $j = $i++) {
            $xi = $polygon[$i][0];
            $yi = $polygon[$i][1];
            $xj = $polygon[$j][0];
            $yj = $polygon[$j][1];

            $intersect = (($yi > $y) != ($yj > $y))
                && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }

}