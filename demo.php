<?php
require_once(__DIR__.'/autoload.php');

function parsePlain($string, $valueDelim=':', $groupDelim=',')
{
    $result = [];
    foreach(explode($groupDelim, $string) as $value)
    {
        $value = explode($valueDelim, $value);
        $result[$value[0]] = $value[1];
    }
    return $result;
}

function parseRegex($string, $valueDelim=':', $groupDelim=',')
{
    preg_match_all('/([^'.$groupDelim.']+)'.$valueDelim.'([^'.$groupDelim.']+)/', $string, $matches);
    return array_combine($matches[1], $matches[2]);
}

set_time_limit(0);

$measure    = new \Benchmark\Measure;
$string     = join(',', array_map(function($x)
{
    return 'val'.mt_rand(1, 1E6).':'.mt_rand(1, 1E6);
}, range(1, 1E3)));

$x          = $measure->benchmarkTime('parsePlain', [$string], (int)1E4);
$y          = $measure->benchmarkTime('parseRegex', [$string], (int)1E4);
var_dump($x, $y);
