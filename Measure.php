<?php
namespace Benchmark;

final class Measure
{
    const MEMORY_VALUE      = 0;
    const BENCHMARK_VALUE   = 1;
    const BENCHMARK_AVERAGE = 2;
    const BENCHMARK_COUNT   = 3;
    
    private $max, $memory;

    public function memoryTick()
    {
       $this->memory = memory_get_usage() - $this->memory;
       $this->max    = $this->memory>$this->max?$this->memory:$this->max;
       $this->memory = memory_get_usage();
    }
    /**
     * 
     * @param callable $function A function to be measured
     * @param array $args Parameters to be passed for measured function
     * @return array Result currently contains one value: used memory space
     */
    public function benchmarkMemory(callable $function, $args=[])
    {
       declare(ticks=1);
       $this->memory = memory_get_usage();
       $this->max    = 0;

       register_tick_function('call_user_func', [$this, 'memoryTick']);
       $this->measureFunction($function, $args, 1);
       unregister_tick_function('call_user_func');
       return [
          self::MEMORY_VALUE => $this->max
       ];
    }
    /**
     * 
     * @param callable $function A function to be measured
     * @param array $args Parameters to be passed for measured function
     * @param int $count Count of measurements
     * @return array Result currently contains: total time, average time and measurements count
     * @throws \InvalidArgumentException If measurements count is invalid
     */
    public function benchmarkTime(callable $function, array $args=[], $count=1)
    {
        return $this->benchmarkCustom('microtime', $function, [1], $args, $count);
    }
    /**
     * 
     * @param callable $benchmark Function which will do measurements
     * @param callable $function A function to be measured
     * @param array $benchmarkArgs Parameters to be passed for measurement function
     * @param array $functionArgs Parameters to be passed for measured function
     * @param int $count Count of measurements
     * @return array Result currently contains: total value, average value and measurements count
     * @throws \InvalidArgumentException If measurements count is invalid
     * @throws \LogicException If measurement function did not returned numeric value
     */
    public function benchmarkCustom(callable $benchmark, callable $function, array $benchmarkArgs=[], array $functionArgs=[], $count=1)
    {
        if(!is_int($count) || $count <=0)
        {
            throw new \InvalidArgumentException('Count of measure times must be positive integer');
        }
        $init   = call_user_func_array($benchmark, $benchmarkArgs);
        if(!is_numeric($init))
        {
            throw new \LogicException('Benchmark function must return valid numeric value');
        }
        $this->measureFunction($function, $functionArgs, $count);
        $end    = call_user_func_array($benchmark, $benchmarkArgs);
        return [
            self::BENCHMARK_VALUE    => $end - $init,
            self::BENCHMARK_AVERAGE  => ($end - $init) / $count,
            self::BENCHMARK_COUNT    => $count
        ];
    }
    
    private function measureFunction($function, $args, $count)
    {
        for($i=0; $i<$count; $i++)
        {
            $result = call_user_func_array($function, $args);
        }
    }
}