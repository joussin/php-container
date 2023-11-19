<?php

namespace Joussin\Component\Container;

class Container extends \ArrayObject implements DependencyInjectionContainerInterface
{
    use UtilsTypes;

    /**
     * @var Resolver
     */
    protected $resolver;


    /** The container's  instance.
     *
     * @var static
     */
    protected static $instance;


    /**
     *  try {
    } catch (\Exception $e)
    {
    throw new ContainerException();
    }
     *   get Singleton instance of the class
 
     * @param array|object $array
     * @return static
     */
    public static function instance(array $array = [])
    {
        if (is_null(static::$instance)) {
            static::$instance = new static($array);
            static::$instance->setResolver(new Resolver());
        }
        return static::$instance;
    }


    private function __construct(array $array = [], int $flags = \ArrayObject::STD_PROP_LIST | \ArrayObject::ARRAY_AS_PROPS, string $iteratorClass = "ArrayIterator")
    {
        parent::__construct($array, $flags, $iteratorClass);
    }


    public function get(string $id)
    {
        if ($alias = $this->offsetGet($id)) {
            return $alias;
        }
        throw new NotFoundException();
    }

    public function has(string $id): bool
    {
        return $this->offsetExists($id);
    }


    public function add(string $abstract, $concrete): void
    {
        $this->offsetSet($abstract, $concrete);
    }



    /**
     * @return Resolver
     */
    public function getResolver(): Resolver
    {
        return $this->resolver;
    }


    /**
     * @param Resolver $resolver
     */
    public function setResolver(Resolver $resolver): void
    {
        $this->resolver = $resolver;
    }


    public function make($class, $parameters = [])
    {
        return $this->getResolver()->make($class, $parameters);
    }




    public function alias(string $abstract, $concrete): bool
    {
        return class_alias($abstract, $concrete);
    }


    /**
     * @param string $class Class name
     * @return bool
     */
    function is_alias(string $class): bool
    {
        return $class !== (new \ReflectionClass($class))->name;
    }



}