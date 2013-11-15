benchmark
=========

Benchmark is a very simple tool that allows to measure functions in PHP. 

Currently, there are two standard measurements: memory space and time. 

Memory
======

To measure memory, it's enough to use \Benchmark\Measure::benchmarkMemory method
- it measures maximum memory space that was used during function execution

Time
====

To measure time, solid amount of iterations should be applied. Method is 
\Benchmark\Measure::benchmarkTime Also make sure that your script has enough
time limitations, otherwise your script will fail because this measure tool
does not affects any context and so you should adjust your maximum script
execution time by yourself (using set_time_limit() for example).

Custom
======

You may specify any measurement function and use it in \Benchmark\Measure::benchmarkCustom
- the only restriction is that value, returned by this measurement function
must be numeric value.
