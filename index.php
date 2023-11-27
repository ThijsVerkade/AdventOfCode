<?php

declare(strict_types=1);

require_once(__DIR__ . '/vendor/autoload.php');

$day = new Day\DayTen();

echo "SolutionOne:";
$day->solutionOne();
echo "SolutionTwo:";
$day->solutionTwo();
