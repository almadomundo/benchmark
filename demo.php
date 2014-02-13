<?php
spl_autoload_register(function($className)
{
    $path = explode('\\', $className);
    include_once(end($path).'.php');
});


class Foo
{
    public function baz($string, $prefix='')
    {
        $result = $prefix.strrev($string);
        return $result;
    }
    
    public function bar()
    {
        $tmp  = str_repeat('test', 1E4);
        $tmp  = $this->baz($tmp);
        $data = preg_split('//', $tmp);
        return $data;
    }
}
$measure    = new \Benchmark\Measure;
/*
$result     = $measure->benchmarkMemory('str_repeat', ['test', 1E4]);
var_dump($result);
$result     = $measure->benchmarkMemory('str_repeat', ['test', 1E3]);
var_dump($result);
$result     = $measure->benchmarkTime('uniqid', [1], 1000);
var_dump($result);
*/
$obj = new Foo();
$result     = $measure->profileMemory([$obj, 'bar']);
var_dump($result);