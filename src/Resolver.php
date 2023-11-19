<?php

namespace Joussin\Component\Container;


class Resolver implements ResolverInterface
{

    public function make($class, $parameters = [])
    {
        $reflectionInfos = UtilsTypes::reflectionInfos($class);

        $parameters = $this->resolveParameters($parameters, $reflectionInfos['requiredParameters']);

        return call_user_func_array([$reflectionInfos['reflection'], $reflectionInfos['constructorMethodName']], $parameters);
    }


    public function resolveParameters(array $parameters, array $requiredParameters)
    {
        $missingParameters = array_diff_key($requiredParameters, $parameters);

        array_walk($missingParameters, function ($missingParameter, $key) use (&$parameters) {
            $parameters[] = $this->resolveParameter($missingParameter);
        });

        return $parameters;
    }

    public function resolveParameter(\ReflectionParameter $constructorParam)
    {
        if (UtilsTypes::matchParameter($constructorParam, true, false)) {
            return $this->make($constructorParam->getType()->getName());
        } else if (
            UtilsTypes::matchParameter($constructorParam, true, true, true) ||
            UtilsTypes::matchParameter($constructorParam, null, null, true)
        ) {
            return $constructorParam->getDefaultValue();
        } else if (UtilsTypes::matchParameter($constructorParam, null, null, null, null, true)) {
            return null;
        }
        throw new \Exception("Can not resolve parameters");
    }

}
