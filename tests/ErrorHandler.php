<?php
namespace Tests;

class ErrorHandler
{
    protected $catchedError = null;
    protected $exception    = null;
    
    public function __construct($catchedError, \Exception $e)
    {
        $this->exception    = $e;
        $this->catchedError = $catchedError;
    }
    
    public function handler($errno, $errstr, $errfile, $errline)
    {
        if($this->catchedError===$errno)
        {
            throw $this->exception;
        }
    }
}