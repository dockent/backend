<?php

namespace Dockent\components\config;

use Phalcon\Config as PhalconConfig;

/**
 * Class Config
 * @package Dockent\components\config
 */
class Config extends PhalconConfig
{
    /**
     * @var Configurable[]
     */
    private $storage = [];

    /**
     * @var string
     */
    private $configPath;

    /**
     * Config constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->configPath = $path;
        parent::__construct(require $this->configPath);
    }

    /**
     * @param Configurable $data
     */
    public function add(Configurable $data): void
    {
        $this->storage[] = $data;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $result = $this->toArray();
        foreach ($this->storage as $item) {
            $result = array_merge($result, $item->pasteToConfig());
        }

        $save = (bool)file_put_contents($this->configPath,
            '<?php return ' . var_export($result, true) . ';');
        if ($save) {
            foreach ($this->storage as $item) {
                $item->afterSave();
            }
            $this->storage = [];
        }

        return $save;
    }
}