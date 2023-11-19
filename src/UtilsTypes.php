<?php

namespace Joussin\Component\Container;

trait UtilsTypes
{

    /**
     * Les variables scalaires sont celles qui contiennent un entier, un nombre décimal, une chaîne de caractères ou un booléen.
    Les types array, object, resource et null ne sont pas scalaires.
     *
     * @param $value
     * @return bool
     */
    public static function isPrimitive($value) : bool
    {
        return (is_scalar($value) || is_array($value) || is_null($value)) && (!is_object($value) && !is_resource($value) && !is_callable($value)) && (!static::isCallable($value) && !static::isClass($value));
    }


    public static function isCallable($value) : bool
    {
        return !static::isPrimitive($value) && is_callable($value) && $value instanceof \Closure;
    }


    public static function isInstance($value) : bool
    {
        return !(is_callable($value) && $value instanceof \Closure) && is_object($value);
    }

    public static function isClass($value) : bool
    {
        return (
            !is_callable($value) &&
            !is_object($value) &&
            class_exists($value) &&
            (new \ReflectionClass($value))
        );
    }


    public static function matchParameter(\ReflectionParameter $parameter,
                                   ?bool                $withType = null,
                                   ?bool                $isBuiltin = null,
                                   ?bool                $withDefault = null,
                                   ?bool                $isOptional = null,
                                   ?bool                $isNullable = null
    )
    {
        // $withDefault = null : all ok
        // $withDefault = true : all with default only ok
        // $withDefault = false : all without default ok

        $withDefaultValid = is_null($withDefault) || $parameter->isDefaultValueAvailable() == $withDefault;
        $isOptionalValid = is_null($isOptional) || $parameter->isOptional() == $isOptional;
        $withTypeValid = is_null($withType) || $parameter->hasType() == $withType;
        // A built-in type is any type that is not a class, interface, or trait.
        $isBuiltinValid = is_null($isBuiltin) || $parameter->hasType() && $parameter->getType()->isBuiltin() == $isBuiltin;
        $isNullableValid = is_null($isNullable) || $parameter->allowsNull() == $isNullable;

        return $withDefaultValid && $isOptionalValid && $withTypeValid && $isBuiltinValid && $isNullableValid;
    }

    /**
     * @param \ReflectionParameter[] $parameters
     * @param bool|null $withType
     * @param bool|null $isBuiltin
     * @param bool|null $withDefault
     * @param bool|null $isOptional
     * @param bool|null $isNullable
     * @return array
     */
    public static function filterParameters(array $constructorParameters = [],
                                   ?bool                $withType = null,
                                   ?bool                $isBuiltin = null,
                                   ?bool                $withDefault = null,
                                   ?bool                $isOptional = null,
                                   ?bool                $isNullable = null
    )
    {
        return array_filter($constructorParameters, fn($parameter) => $this->matchParameter($parameter, $withType, $isBuiltin, $withDefault, $isOptional, $isNullable));
    }


    /**
     *            $requiredParameters = array_filter($constructorParameters, fn($parameter) => !$parameter->isOptional());
    $requiredClassParameters = array_filter($requiredParameters, fn($parameter) => $parameter->getType() instanceof \ReflectionNamedType && !$parameter->getType()->isBuiltin());
    $requiredPrimitiveParameters = array_filter($constructorParameters, fn($parameter) => $parameter->getType() && $parameter->getType()->isBuiltin());
    $optionalParameters = array_filter($constructorParameters, fn($parameter) => $parameter->isOptional());
    $withDefaultParameters = array_filter($constructorParameters, fn($parameter) => $parameter->isDefaultValueAvailable());

     *
     * @param $class
     * @return array|null
     */
    public static function reflectionInfos($class, ?bool $isOptional = false, ?bool $isBuiltin = null): ?array
    {
        try {
            $reflection = new \ReflectionClass($class);

            $constructorParameters = $reflection->isInstantiable() && $reflection->getConstructor() ? $reflection->getConstructor()->getParameters() : [];
            $requiredParameters = static::filterParameters($constructorParameters, null, $isBuiltin, null, $isOptional, null);
            $constructorMethodName = $reflection->getConstructor() ? 'newInstance' : 'newInstanceWithoutConstructor';

            return [
                'reflection'                => $reflection,
                'constructorParameters'     => $constructorParameters,
                'requiredParameters'        => $requiredParameters,
                'constructorMethodName'     => $constructorMethodName,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

}