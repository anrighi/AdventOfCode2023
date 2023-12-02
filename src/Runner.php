<?php
namespace AOC;

require_once __DIR__ . '/../vendor/autoload.php';

use AOC\Calendar\Day1;
use AOC\Calendar\Day2;

$calendar = [
    new Day2(),
    new Day1(),
];

foreach ($calendar as $day) {
    $day->run();
}
