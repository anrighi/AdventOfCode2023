<?php

namespace AOC\Calendar;

use AOC\Utility\Parser;
use AOC\Utility\Wrapper;

class Day6
{
    public const DAY_NUMBER = '6';

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
            preg_match_all('/\d+/', $lines[0], $time);
            preg_match_all('/\d+/', $lines[1], $distance);

            $time = $time[0];
            $distance = $distance[0];

            $wins = array_fill(0, count($time), 0);

            foreach ($time as $key => $maxTime) {

                for ($i = 1; $i < $maxTime; $i++) {
                    $myDistance = $i * ($maxTime - $i);

                    if ($myDistance > $distance[$key]) {
                        $wins[$key]++;
                    }
                }
            }

            return array_product($wins);
        });
    }

    protected function partTwo()
    {
        $lines = $this->lines;

        Wrapper::partWrapper(2, function () use ($lines) {
            preg_match_all('/\d+/', $lines[0], $time);
            preg_match_all('/\d+/', $lines[1], $distance);

            $time = implode('', $time[0]);
            $distance = implode('', $distance[0]);

            $winCounter = 0;


            for ($i = 1; $i < $time; $i++) {
                $myDistance = $i * ($time - $i);

                if ($myDistance > $distance) {
                    $winCounter++;
                }
            }

            return $winCounter;
        });
    }

    public function run()
    {
        Wrapper::printHeader(self::DAY_NUMBER);

        $this->partOne();
        $this->partTwo();
    }
}
