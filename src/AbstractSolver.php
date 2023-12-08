<?php

declare(strict_types=1);

namespace AdventOfCode;

use AdventOfCode\Enums\Scenario;
use Exception;

abstract class AbstractSolver
{
    public function getTestScenario(string $dir, Scenario $name = Scenario::testScenario1): array
    {
        $path = sprintf('%s/%s.txt', $dir, $name->value);
        $file = file($path, FILE_IGNORE_NEW_LINES);

        if (!$file) {
            throw new Exception(sprintf('%s file is not found', $file));
        }

        return $file;
    }
}