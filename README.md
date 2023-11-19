
$this->instance('path', $this->path());
$this->instance('path.base', $this->basePath());
$this->instance('path.config', $this->configPath());
$this->instance('path.public', $this->publicPath());
$this->instance('path.storage', $this->storagePath());
$this->instance('path.database', $this->databasePath());
$this->instance('path.resources', $this->resourcePath());
$this->instance('path.bootstrap', $this->bootstrapPath());


`````json
{
  "require": {
    "php": "^8.0.2",
    "psr/container": "^1.1.1|^2.0.1"
  },
  "provide": {
    "psr/container-implementation": "1.1|2.0"
  }
}
`````

