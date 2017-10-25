<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 24.10.17
 * Time: 14:49
 */

namespace Dockent\components;

use Phalcon\Config as PhalconConfig;

/**
 * Class Config
 * @package Dockent\components
 */
class Config extends PhalconConfig
{
    /**
     * @var Configurable[]
     */
    private $storage = [];

    /**
     * @param Configurable $data
     */
    public function add(Configurable $data)
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

        $save = (bool)file_put_contents('./app/config.php',
            '<?php return ' . var_export($result, true) . ';');
        if ($save) {
            foreach ($this->storage as $item) {
                $item->afterSave();
            }
        }

        return $save;
    }
}