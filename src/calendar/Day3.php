<?php

namespace AOC\Calendar;

use AOC\Utility\Parser;
use AOC\Utility\Wrapper;

class Day3
{
    public const DAY_NUMBER = '3';

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

            $whereNumbers = [];

            foreach ($lines as $idx => $line) {
                preg_match_all('!\d+!', $line, $matches);
                $matches = $matches[0];

                $parsedLine = $line;

                foreach ($matches as $match) {

                    $replaceString = str_repeat('?', strlen($match));
                    $position = strpos($parsedLine, $match);

                    $parsedLine = substr_replace($parsedLine, $replaceString, $position, strlen($match));
                    $whereNumbers[] = [$idx, $position, $match];
                }
            }

            foreach ($whereNumbers as $whereNumber) {
                $line = $whereNumber[0];
                $pos = $whereNumber[1];
                $number = $whereNumber[2];
                $length = strlen($number);

                for ($i = -1; $i <= $length; $i++) {

                    $characters = [];

                    if ($line - 1 >= 0 && $pos + $i >= 0 && $pos + $i < strlen($lines[0])) {
                        $characters[] = $lines[$line - 1][$pos + $i];
                    }

                    if ($pos + $i >= 0 && $pos + $i < strlen($lines[0])) {
                        $characters[] = $lines[$line][$pos + $i];
                    }

                    if ($line + 1 < count($lines) && $pos + $i >= 0 && $pos + $i < strlen($lines[0])) {
                        $characters[] = $lines[$line + 1][$pos + $i];
                    }

                    $arrayContainsSymbol = array_filter($characters, function ($character) {
                        return !is_numeric($character) && $character !== '.';
                    });

                    if (!empty($arrayContainsSymbol)) {
                        $total += $number;
                        break;
                    }
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

            $whereSymbols = [];

            foreach ($lines as $idx => $line) {
                preg_match_all('!\*!', $line, $matches);
                $matches = $matches[0];

                $parsedLine = $line;

                foreach ($matches as $match) {

                    $replaceString = str_repeat('?', strlen($match));
                    $position = strpos($parsedLine, $match);

                    $parsedLine = substr_replace($parsedLine, $replaceString, $position);
                    $whereSymbols[] = [$idx, $position];
                }
            }

            foreach ($whereSymbols as $whereSymbol) {
                $line = $whereSymbol[0];
                $pos = $whereSymbol[1];

                $lineBefore = $lines[$line - 1];
                $lineCurrent = $lines[$line];
                $lineAfter = $lines[$line + 1];

                $partBefore = substr($lineBefore, $pos - 1, 3);
                $partCurrent = substr($lineCurrent, $pos - 1, 3);
                $partAfter = substr($lineAfter, $pos - 1, 3);

                $isBeforeNumeric = !empty(preg_match('/\d/', $partBefore));
                $isCurrentNumeric = !empty(preg_match('/\d/', $partCurrent));
                $isAfterNumeric = !empty(preg_match('/\d/', $partAfter));

                $numericParts = array_filter([$isBeforeNumeric, $isCurrentNumeric, $isAfterNumeric], function ($isNumeric) {
                    return $isNumeric;
                });

                $getStringPart = function ($part, $string) {
                    $offset = 0;
                    $position = strpos($string, $part);

                    if (strlen($part) > 2) {

                        if (is_numeric($part)) {
                            $offset = $position - 2;
                        } elseif ($part[0] === '.') {
                            $offset = $position;
                        } elseif ($part[1] === '.') {
                            if (is_numeric($part[0])) {
                                $offset = $position - 3;
                            } else {
                                $offset = $position + 2;
                            }
                        }
                    } elseif ($position < 3) {
                        $offset = 0;
                    } else {
                        $offset = $position - 2;
                    }

                    if ($offset < 0) {
                        $offset = 0;
                    }

                    $length = 10;

                    echo "$part - $offset - $length: " . substr($string, $offset, $length) . PHP_EOL;

                    return substr($string, $offset, $length);
                };

                if (count($numericParts) === 2) {

                    if ($isBeforeNumeric) {
                        preg_match('!\d+!', $getStringPart($partBefore, $lineBefore), $beforeNumber);

                        if ($isCurrentNumeric) {

                            if (is_numeric($partCurrent[0])) {
                                preg_match('!\d+!', substr($lineCurrent, $pos - 4), $currentNumber);
                            } else {
                                preg_match('!\d+!', substr($lineCurrent, $pos + 1), $currentNumber);
                            }

                            $total += $beforeNumber[0] * $currentNumber[0];

                            echo $beforeNumber[0] . ' * ' . $currentNumber[0] . ' = ' . $beforeNumber[0] * $currentNumber[0] . PHP_EOL;
                        } else {
                            preg_match('!\d+!', $getStringPart($partAfter, $lineAfter), $afterNumber);
                            $total += $beforeNumber[0] * $afterNumber[0];

                            echo $beforeNumber[0] . ' * ' . $afterNumber[0] . ' = ' . $beforeNumber[0] * $afterNumber[0] . PHP_EOL;
                        }
                    } else {
                        if (is_numeric($partCurrent[0])) {
                            preg_match('!\d+!', substr($lineCurrent, $pos - 4), $currentNumber);
                        } else {
                            preg_match('!\d+!', substr($lineCurrent, $pos + 1), $currentNumber);
                        }

                        preg_match('!\d+!', $getStringPart($partAfter, $lineAfter, $pos), $afterNumber);

                        $total += $currentNumber[0] * $afterNumber[0];

                        echo $currentNumber[0] . ' * ' . $afterNumber[0] . ' = ' . $currentNumber[0] * $afterNumber[0] . PHP_EOL;
                    }
                }

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
