benchmark
=========

Benchmark is a very simple tool that allows to measure functions in PHP. 

Currently, there are two standard measurements: memory space and time.

Important note: this tool is created for comparative measurements. That means -
it is good only to compare memory/time usage of two or more functions. If you
want to get exact memory/time measurements - using this tool is not a good idea
because it's realization wraps many things inside class, calls internal methods
e t.c. - i.e. it does many things that cause measurements overhead.

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
