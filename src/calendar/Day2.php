<?php

namespace AOC\Calendar;

use AOC\Utility\Parser;
use AOC\Utility\Wrapper;

class Day2
{
    public const DAY_NUMBER = '2';

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
            $total = 0;
            $maxRed = 12;
            $maxGreen = 13;
            $maxBlue = 14;

            foreach ($lines as $line) {

                $parsing = explode(':', $line);

                $gameId = $parsing[0];
                $gameId = (int) (str_replace('Game ', '', $gameId));

                $games = explode(';', $parsing[1]);

                $possible = true;

                foreach ($games as $game) {

                    $red = 0;
                    $green = 0;
                    $blue = 0;

                    foreach (explode(',', $game) as $color) {
                        if (strpos($color, 'red') !== false) {
                            $red = (int) (str_replace('red', '', $color));
                        }

                        if (strpos($color, 'green') !== false) {
                            $green = (int) (str_replace('green', '', $color));
                        }

                        if (strpos($color, 'blue') !== false) {
                            $blue = (int) (str_replace('blue', '', $color));
                        }
                    }

                    if ($red > $maxRed || $green > $maxGreen || $blue > $maxBlue) {
                        $possible = false;
                    }
                }

                if ($possible) {
                    $total += $gameId;
                }
            }

            return $total;
        });
    }

    protected function partTwo()
    {
        $lines = $this->lines;

        Wrapper::partWrapper(2, function () use ($lines) {
            $total = 0;

            foreach ($lines as $line) {

                $maxRed = 0;
                $maxGreen = 0;
                $maxBlue = 0;

                $parsing = explode(':', $line);

                $gameId = $parsing[0];
                $gameId = (int) (str_replace('Game ', '', $gameId));

                $games = explode(';', $parsing[1]);

                foreach ($games as $game) {

                    foreach (explode(',', $game) as $color) {
                        if (strpos($color, 'red') !== false) {
                            $red = (int) (str_replace('red', '', $color));

                            if ($red > $maxRed) {
                                $maxRed = $red;
                            }
                        }

                        if (strpos($color, 'green') !== false) {
                            $green = (int) (str_replace('green', '', $color));

                            if ($green > $maxGreen) {
                                $maxGreen = $green;
                            }
                        }

                        if (strpos($color, 'blue') !== false) {
                            $blue = (int) (str_replace('blue', '', $color));

                            if ($blue > $maxBlue) {
                                $maxBlue = $blue;
                            }
                        }
                    }
                }

                $total += $maxRed * $maxGreen * $maxBlue;
            }

            return $total;
        });
    }

    public function run()
    {
        Wrapper::printHeader(self::DAY_NUMBER);

        $this->partOne();
        $this->partTwo();
    }
}
