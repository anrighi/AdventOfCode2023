<?php

namespace AOC\Calendar;

use AOC\Utility\Parser;
use AOC\Utility\Wrapper;

class Day7
{
    public const DAY_NUMBER = '7';

    private array $lines;
    private const FIVE_OF_A_KIND = 7;
    private const FOUR_OF_A_KIND = 6;
    private const FULL_HOUSE = 5;
    private const THREE_OF_A_KIND = 4;
    private const TWO_PAIRS = 3;
    private const ONE_PAIR = 2;
    private const HIGH_CARD = 1;

    public function __construct()
    {
        $this->lines = Parser::parseInputWrapper(function () {
            $fileContent = file_get_contents(__DIR__ . '/../../input/day' . self::DAY_NUMBER . '.txt');
            return explode("\n", $fileContent);
        });
    }

    private function handValue(string $hand)
    {
        $cards = str_split($hand);
        $cards = array_count_values($cards);

        usort($cards, function ($a, $b) {
            return $a <=> $b;
        });

        $cards = array_reverse($cards);

        switch ($cards[0]) {
            case 5:
                return self::FIVE_OF_A_KIND;
            case 4:
                return self::FOUR_OF_A_KIND;
            case 3:
                if ($cards[1] === 2) {
                    return self::FULL_HOUSE;
                }

                return self::THREE_OF_A_KIND;
            case 2:
                if ($cards[1] === 2) {
                    return self::TWO_PAIRS;
                }

                return self::ONE_PAIR;
            default:
                return self::HIGH_CARD;
        }
    }

    private function handValueWithJoker(string $hand)
    {
        $cards = str_split($hand);
        $cards = array_count_values($cards);

        usort($cards, function ($a, $b) {
            return $a <=> $b;
        });

        $cards = array_reverse($cards);

        switch ($cards[0]) {
            case 5:
                return self::FIVE_OF_A_KIND;
            case 4:
                if (str_contains($hand, 'J')) {
                    return self::FIVE_OF_A_KIND;
                }

                return self::FOUR_OF_A_KIND;
            case 3:
                $jokerCounts = substr_count($hand, 'J');

                if ($cards[1] === 2) {
                    if ($jokerCounts >= 2) {
                        return self::FIVE_OF_A_KIND;
                    }

                    return self::FULL_HOUSE;
                }

                if ($jokerCounts > 0) {
                    return self::FOUR_OF_A_KIND;
                }

                return self::THREE_OF_A_KIND;
            case 2:
                $jokerCounts = substr_count($hand, 'J');

                if ($cards[1] === 2) {
                    if ($jokerCounts === 2) {
                        return self::FOUR_OF_A_KIND;
                    } elseif ($jokerCounts === 1) {
                        return self::FULL_HOUSE;
                    }

                    return self::TWO_PAIRS;
                }

                if ($jokerCounts > 0) {
                    return self::THREE_OF_A_KIND;
                }

                return self::ONE_PAIR;
            default:
                if (str_contains($hand, 'J')) {
                    return self::ONE_PAIR;
                }

                return self::HIGH_CARD;
        }
    }


    protected function partOne()
    {
        $lines = $this->lines;

        Wrapper::partWrapper(1, function () use ($lines) {

            $games = [];

            foreach ($lines as $line) {
                $game = explode(' ', $line);

                $games[] = [
                    'hand' => $game[0],
                    'bid' => $game[1],
                    'handValue' => $this->handValue($game[0])
                ];
            }

            usort($games, function ($a, $b) {
                if ($a['handValue'] === $b['handValue']) {

                    foreach (str_split($a['hand']) as $key => $card) {

                        if ($card === $b['hand'][$key]) {
                            continue;
                        }

                        $cardOrder = ['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'];

                        return array_search($b['hand'][$key], $cardOrder) <=> array_search($card, $cardOrder) ;
                    }

                }

                return $a['handValue'] <=> $b['handValue'];
            });

            $winnings = 0;

            foreach ($games as $idx => $game) {
                $winnings += $game['bid'] * ($idx + 1);
            }

            return $winnings;
        });
    }

    protected function partTwo()
    {
        $lines = $this->lines;

        Wrapper::partWrapper(2, function () use ($lines) {
            $games = [];

            foreach ($lines as $line) {
                $game = explode(' ', $line);

                $games[] = [
                    'hand' => $game[0],
                    'bid' => $game[1],
                    'handValue' => $this->handValueWithJoker($game[0])
                ];
            }

            usort($games, function ($a, $b) {
                if ($a['handValue'] === $b['handValue']) {

                    foreach (str_split($a['hand']) as $key => $card) {

                        if ($card === $b['hand'][$key]) {
                            continue;
                        }

                        $cardOrder = ['A', 'K', 'Q', 'T', '9', '8', '7', '6', '5', '4', '3', '2', 'J'];

                        return array_search($b['hand'][$key], $cardOrder) <=> array_search($card, $cardOrder) ;
                    }

                }

                return $a['handValue'] <=> $b['handValue'];
            });

            $winnings = 0;

            foreach ($games as $idx => $game) {
                $winnings += $game['bid'] * ($idx + 1);
            }

            return $winnings;
        });
    }

    public function run()
    {
        Wrapper::printHeader(self::DAY_NUMBER);

        $this->partOne();
        $this->partTwo();
    }
}
