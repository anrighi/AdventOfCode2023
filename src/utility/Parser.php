<?php

namespace AOC\Utility;

class Parser
{
    public static function parseInputWrapper(callable $callback)
    {
        echo 'Started parsing input' . "\n";
        $startParsing = microtime(true);

        $lines = $callback();

        $endParsing = microtime(true);
        echo 'Finished parsing input in ' . ($endParsing - $startParsing) . ' seconds' . "\n";

        return $lines;
    }
}
