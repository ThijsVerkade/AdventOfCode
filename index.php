<?php

declare(strict_types=1);

require_once(__DIR__ . '/vendor/autoload.php');

$day = new AdventOfCode\Year2023\Day1\Solver();

echo "SolutionOne:";
$day->solutionOne();
echo "\nSolutionTwo:";
$day->solutionTwo();
