<?php

namespace AOC\Calendar;

use AOC\Utility\Parser;
use AOC\Utility\Wrapper;

class Day4
{
    public const DAY_NUMBER = '4';

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

            foreach ($lines as $line) {

                $parsing = explode(':', $line);

                $gameId = $parsing[0];
                $gameId = (int) (str_replace('Card ', '', $gameId));

                $series = explode('|', $parsing[1]);
                $winning = explode(' ', $series[0]);
                $actual = explode(' ', $series[1]);

                $winning = array_filter($winning, function ($value) {
                    return is_numeric($value);
                });

                $actual = array_filter($actual, function ($value) {
                    return is_numeric($value);
                });

                $cardValue = 0;

                foreach ($actual as $number) {
                    if (in_array($number, $winning)) {

                        if ($cardValue === 0) {
                            $cardValue = 1;
                        } else {
                            $cardValue *= 2;
                        }
                    }
                }

                $total += $cardValue;
            }

            return $total;
        });
    }

    protected function partTwo()
    {
        $lines = $this->lines;

        Wrapper::partWrapper(2, function () use ($lines) {
            $counter = 1;

            $scratchCards = [];

            foreach ($lines as $line) {

                if (!isset($scratchCards[$counter])) {
                    $scratchCards[$counter] = 0;
                }

                $scratchCards[$counter] += 1;

                $parsing = explode(':', $line);

                $gameId = $parsing[0];
                $gameId = (int) (str_replace('Card ', '', $gameId));

                $series = explode('|', $parsing[1]);
                $winning = explode(' ', $series[0]);
                $actual = explode(' ', $series[1]);

                $winning = array_filter($winning, function ($value) {
                    return is_numeric($value);
                });

                $actual = array_filter($actual, function ($value) {
                    return is_numeric($value);
                });

                $cardWinned = 0;

                foreach ($actual as $number) {
                    if (in_array($number, $winning)) {
                        $cardWinned += 1;
                    }
                }

                $cardValue = 1;

                if (isset($scratchCards[$counter])) {
                    $cardValue = $scratchCards[$counter];
                }

                for ($i = 1; $i <= $cardWinned; $i++) {

                    if (!isset($scratchCards[$i + $counter])) {
                        $scratchCards[$i + $counter] = 0;
                    }

                    $scratchCards[$i + $counter] += $cardValue;
                }

                $counter++;
            }

            return array_sum($scratchCards);
        });
    }

    public function run()
    {
        Wrapper::printHeader(self::DAY_NUMBER);

        $this->partOne();
        $this->partTwo();
    }
}
