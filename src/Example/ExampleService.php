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
class ExampleService
{
    private $dependency;
    private $args;
    private $args2;

//    public function __construct(ExampleService2 $dependency, int $args=1, $args2 = 11)
    public function __construct(int $args=1, $args2 = 11)
    {
        $this->args = $args;
        $this->args2 = $args2;
    }
}