<?php

namespace AOC;

require_once __DIR__ . '/../vendor/autoload.php';

use AOC\Calendar\Day1;
use AOC\Calendar\Day2;
use AOC\Calendar\Day3;
use AOC\Calendar\Day4;
use AOC\Calendar\Day6;
use AOC\Calendar\Day7;
use AOC\Calendar\Day8;

$calendar = [
    new Day1(),
    new Day2(),
    new Day3(),
    new Day4(),
    //new Day6(),
    new Day8(),
    new Day7(),
];

foreach ($calendar as $day) {
    $day->run();
}
