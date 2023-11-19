<?php

namespace Joussin\Component\Container\Example;

//class ExampleService
//{
//    public function example() : string
//    {
//        return "ExampleService:example()";
//    }
//
//    public function __construct()//string $arg, bool $is = true
//    {}
//}
class ExampleService2
{
    public function example() : string
    {
        return "ExampleService2:example()";
    }
 public $arg;
    public function __construct($arg)//string $arg = "", bool $is = true
    {
   $this->arg = $arg;
    }
}