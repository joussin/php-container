"provide": {
"psr/container-implementation": "1.1|2.0"
},


        "psr/container": "^2.0"

## Example:

````php
class SomeDependency {
    public function ex(){}
}
class AnotherDependency {}

$aliases = [
//    stdClass::class => new stdClass(),
];

$container =  \Joussin\Component\Container\Container::instance($aliases);

$container->add(AnotherDependency::class, "HELLO");
$container->add(SomeDependency::class, function(){
    return new SomeDependency();
});


dd(
    $container,
    $container->make(SomeDependency::class),
    $container->make(AnotherDependency::class),
    $container->get(AnotherDependency::class),
);

````





$this->instance('path', $this->path());
$this->instance('path.base', $this->basePath());
$this->instance('path.config', $this->configPath());
$this->instance('path.public', $this->publicPath());
$this->instance('path.storage', $this->storagePath());
$this->instance('path.database', $this->databasePath());
$this->instance('path.resources', $this->resourcePath());
$this->instance('path.bootstrap', $this->bootstrapPath());

