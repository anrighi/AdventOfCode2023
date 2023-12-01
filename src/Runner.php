<?php
namespace AOC;

require_once __DIR__ . '/../vendor/autoload.php';

use AOC\Calendar\Day1;

$calendar = [
    new Day1(),
];

foreach ($calendar as $day) {
    $day->run();
}
