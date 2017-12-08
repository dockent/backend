<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 01.12.17
 * Time: 12:39
 */

namespace Dockent\components;

use Phalcon\Validation;
use Phalcon\Validation\Message\Group;
use Phalcon\Validation\MessageInterface;

/**
 * Class FormModel
 * @package Dockent\components
 */
abstract class FormModel
{
    /**
     * @var Validation
     */
    protected $validator;

    /**
     * @var Group
     */
    private $messages = [];

    /**
     * FormModel constructor.
     */
    public function __construct()
    {
        $this->validator = new Validation();
    }

    /**
     * @param array $inputs
     */
    public function assign(array $inputs)
    {
        foreach ($inputs as $input => $value) {
            if (property_exists($this, $input)) {
                $methodName = 'set' . ucfirst($input);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($value);
                } else {
                    $this->$input = $value;
                }
            }
        }
    }

    /**
     * Validation rules should be set here
     */
    public function rules()
    {
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $this->rules();
        $this->messages = $this->validator->validate(get_object_vars($this));
        return !(bool)count($this->messages);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $messages = [];
        foreach ($this->messages as $message) {
            if (!array_key_exists($message->getField(), $messages)) {
                $messages[$message->getField()] = [];
            }
            $messages[$message->getField()][] = $message->getMessage();
        }

        return $messages;
    }

    /**
     * @param string $field
     * @return MessageInterface[]
     */
    public function getError(string $field): array
    {
        if (empty($this->messages)) {
            return [];
        }
        return $this->messages->filter($field);
    }
}