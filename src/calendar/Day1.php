<?php

namespace AOC\Calendar;

use AOC\Utility\Parser;
use AOC\Utility\Wrapper;

class Day1
{
    public const DAY_NUMBER = '1';

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
                $characters = str_split($line);

                $parsedCharacters = array_values(array_filter($characters, function ($character) {
                    return is_numeric($character);
                }));

                $value = implode('', [$parsedCharacters[0], end($parsedCharacters)]);

                $total += $value;
            }

            return $total;
        });
    }

    protected function partTwo()
    {
        $lines = $this->lines;

        Wrapper::partWrapper(2, function () use ($lines) {
            $total = 0;
            $textDigits = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

            foreach ($lines as $line) {

                $characters = str_split($line);
                $validString = '';

                foreach ($characters as $character) {
                    $validString .= $character;

                    foreach ($textDigits as $k => $textDigit) {
                        $validString = str_replace($textDigit, $k + 1 . $character, $validString);
                    }
                }

                $characters = str_split($validString);

                $parsedCharacters = array_values(array_filter($characters, function ($character) {
                    return is_numeric($character);
                }));

                $value = implode('', [$parsedCharacters[0], end($parsedCharacters)]);

                $total += $value;
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
