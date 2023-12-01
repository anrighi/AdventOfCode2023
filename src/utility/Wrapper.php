<?php

namespace AOC\Utility;

class Wrapper
{
    public static function printHeader(int $dayNumber)
    {
        echo '============================' . "\n";
        echo 'Advent of Code 2023 - Day ' . $dayNumber . "\n";
        echo '============================' . "\n";
    }

    public static function partWrapper(int $part, callable $callback)
    {
        echo 'Started part ' . $part . "\n";
        $startPart1 = microtime(true);

        $total = $callback();

        $endPart1 = microtime(true);
        echo 'Finished part ' . $part . ' in ' . ($endPart1 - $startPart1) . ' seconds' . "\n";
        echo 'Part ' . $part . ' solution: ' . $total . "\n";
    }
}
