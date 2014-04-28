<?php

spl_autoload_register(function($className)
{
    $path = explode('\\', $className);
    
    if(file_exists($path = end($path).'.php'))
    {
        require_once($path);
    }
});

//tests:
spl_autoload_register(function($className)
{
    $path   = explode('\\', $className);
    $class  = array_pop($path);
    $space  = array_pop($path);

    if(file_exists($path = __DIR__.'/'.strtolower($space).'/'.$class.'.php'))
    {
        require_once(__DIR__.'/'.strtolower($space).'/'.$class.'.php');
    }
});