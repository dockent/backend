<?php

namespace Dockent\Tests\models;

use Dockent\components\FormModel;
use Phalcon\Validation;

/**
 * Trait Rules
 * @package Dockent\Tests\models
 * @property FormModel $instance
 */
trait Rules
{
    public function getValidator(): Validation
    {
        $validatorProperty = new \ReflectionProperty($this->instance, 'validator');
        $validatorProperty->setAccessible(true);
        $this->instance->rules();
        /** @var Validation $validatorInstance */
        $validatorInstance = $validatorProperty->getValue($this->instance);

        return $validatorInstance;
    }
}