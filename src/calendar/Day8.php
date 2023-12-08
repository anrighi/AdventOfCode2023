<?php

namespace AOC\Calendar;

use AOC\Utility\Parser;
use AOC\Utility\Wrapper;

class Day8
{
    public const DAY_NUMBER = '8';

    private array $lines;

    public function __construct()
    {
        $this->lines = Parser::parseInputWrapper(function () {
            $fileContent = file_get_contents(__DIR__ . '/../../input/day' . self::DAY_NUMBER . '.txt');
            return explode("\n", $fileContent);
        });
    }

    protected function partOne()
    {
        $lines = $this->lines;

        Wrapper::partWrapper(1, function () use ($lines) {
            $steps = 0;

            $directions = $lines[0];
            $locations = [];

            foreach (array_splice($lines, 2) as $line) {
                $start = substr($line, 0, 3);

                $arrival = explode('= ', $line)[1];
                $arrival = substr($arrival, 1, -1);
                $arrival = explode(',', $arrival);

                $locations[$start] = [
                    'left' => trim($arrival[0]),
                    'right' => trim($arrival[1])
                ];
            }

            $currentLocation = 'AAA';
            $directionCounter = 0;

            while ($currentLocation !== 'ZZZ') {

                if ($directionCounter === strlen($directions)) {
                    $directionCounter = 0;
                }

                $direction = $directions[$directionCounter];

                if ($direction === 'L') {
                    $currentLocation = $locations[$currentLocation]['left'];
                } else {
                    $currentLocation = $locations[$currentLocation]['right'];
                }

                $directionCounter++;
                $steps++;
            }

            return $steps;
        });
    }

    protected function partTwo()
    {
        $lines = $this->lines;

        Wrapper::partWrapper(2, function () use ($lines) {
            $directions = $lines[0];
            $locations = [];

            foreach (array_splice($lines, 2) as $line) {
                $start = substr($line, 0, 3);

                $arrival = explode('= ', $line)[1];
                $arrival = substr($arrival, 1, -1);
                $arrival = explode(',', $arrival);

                $locations[$start] = [
                    'left' => trim($arrival[0]),
                    'right' => trim($arrival[1])
                ];
            }

            $startingPoints = array_filter(array_keys($locations), function ($location) {
                return $location[-1] === 'A';
            });

            $occurrences = [];

            foreach ($startingPoints as $startingPoint) {

                $currentLocation = $startingPoint;
                $steps = 0;
                $directionCounter = 0;

                while ($currentLocation[-1] !== 'Z') {
                    if ($directionCounter === strlen($directions)) {
                        $directionCounter = 0;
                    }

                    $direction = $directions[$directionCounter];

                    if ($direction === 'L') {
                        $currentLocation = $locations[$currentLocation]['left'];
                    } else {
                        $currentLocation = $locations[$currentLocation]['right'];
                    }

                    $directionCounter++;
                    $steps++;

                }

                $occurrences[] = $steps;
            }

            $temp = 1;

            foreach ($occurrences as $occurrence) {
                $temp = gmp_lcm($temp, $occurrence);
            }

            return $temp;
        });
    }

    public function run()
    {
        Wrapper::printHeader(self::DAY_NUMBER);

        $this->partOne();
        $this->partTwo();
    }
}
