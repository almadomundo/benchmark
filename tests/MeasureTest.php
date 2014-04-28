<?php
require_once(__DIR__.'/../autoload.php');

class MeasureTest extends PHPUnit_Framework_TestCase 
{
    //check if obligatory keys exist:
    public function testBenchmarkTimeExistingKeys() 
    {
        $measure    = new \Benchmark\Measure;
        $this->assertTrue(
                array_key_exists(
                        \Benchmark\Measure::BENCHMARK_VALUE,
                        $measure->benchmarkTime('mt_rand')
                )
        );
        $this->assertTrue(
                array_key_exists(
                        \Benchmark\Measure::BENCHMARK_AVERAGE,
                        $measure->benchmarkTime('mt_rand')
                )
        );
        $this->assertTrue(
                array_key_exists(
                        \Benchmark\Measure::BENCHMARK_COUNT,
                        $measure->benchmarkTime('mt_rand')
                )
        );
    }
    
    public function testBenchmarkMemoryExistingKeys() 
    {
        $measure    = new \Benchmark\Measure;
        $this->assertTrue(
                array_key_exists(
                        \Benchmark\Measure::MEMORY_VALUE,
                        $measure->benchmarkMemory('mt_rand')
                )
        );
    }
    
    //check if only measure keys exist:
    public function testBenchmarkTimeNonExistingKeys() 
    {
        $keys = [
            \Benchmark\Measure::BENCHMARK_COUNT,
            \Benchmark\Measure::BENCHMARK_AVERAGE,
            \Benchmark\Measure::BENCHMARK_VALUE
        ];
        $measure    = new \Benchmark\Measure;
        $result     = $measure->benchmarkTime('mt_rand');
        $this->assertTrue(
                array_diff_key($result, array_flip($keys))==[]
        );
    }
    
    public function testBenchmarkMemoryNonExistingKeys() 
    {
        $keys = [
            \Benchmark\Measure::MEMORY_VALUE
        ];
        $measure    = new \Benchmark\Measure;
        $result     = $measure->benchmarkMemory('mt_rand');
        $this->assertTrue(
                array_diff_key($result, array_flip($keys))==[]
        );
    }
    
    //invalid cases:
    public function testBenchmarkTimeNonCallables()
    {
        $measure        = new \Benchmark\Measure;
        $nonCallable    = -1;
        $handler        = new \Tests\ErrorHandler(
                E_RECOVERABLE_ERROR, 
                new \InvalidArgumentException('Non-callable measured function')
        );
        set_error_handler([$handler, 'handler']);
        
        $this->setExpectedException('\InvalidArgumentException');
        $measure->benchmarkTime($nonCallable);
        
        restore_error_handler();
    }
    
    public function testBenchmarkMemoryNonCallables()
    {
        $measure        = new \Benchmark\Measure;
        $nonCallable    = -1;
        $handler        = new \Tests\ErrorHandler(
                E_RECOVERABLE_ERROR, 
                new \InvalidArgumentException('Non-callable measured function')
        );
        set_error_handler([$handler, 'handler']);
        
        $this->setExpectedException('\InvalidArgumentException');
        $measure->benchmarkMemory($nonCallable);
        
        restore_error_handler();
    }
    
    public function testBenchmarkTimeInvalidCount()
    {
        $measure    = new \Benchmark\Measure;
        $count      = 'foo';
        $this->setExpectedException('\InvalidArgumentException');
        $measure->benchmarkTime('mt_rand', [], $count);
    }
    
    public function testBenchmarkCustomNonNumericCallableResult()
    {
        $measure    = new \Benchmark\Measure;
        $callback   = function()
        {
            return 'foo';
        };
        $this->setExpectedException('\LogicException');
        $measure->benchmarkCustom($callback, 'mt_rand');
    }
}