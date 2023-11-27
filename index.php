<?php

declare(strict_types=1);

use Year2022\DayTen\Solver;

require_once(__DIR__ . '/vendor/autoload.php');

$day = new Solver();

echo "SolutionOne:";
$day->solutionOne();
echo "SolutionTwo:";
$day->solutionTwo();
