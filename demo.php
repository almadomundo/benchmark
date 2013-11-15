<?php
spl_autoload_register(function($className)
{
    $path = explode('\\', $className);
    include_once(end($path).'.php');
});

$measure    = new \Benchmark\Measure;

$result     = $measure->benchmarkMemory('str_repeat', ['test', 1E4]);
var_dump($result);
$result     = $measure->benchmarkMemory('str_repeat', ['test', 1E3]);
var_dump($result);
$result     = $measure->benchmarkTime('uniqid', [1], 1000);
var_dump($result);