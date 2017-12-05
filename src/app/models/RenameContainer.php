<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 04.12.17
 * Time: 14:43
 */

namespace Dockent\models;

use Dockent\components\FormModel;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Class RenameContainer
 * @package Dockent\models
 */
class RenameContainer extends FormModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name = '';

    public function rules()
    {
        $this->validator->add(['name'], new PresenceOf());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param \stdClass $container
     */
    public function map(\stdClass $container)
    {
        $this->assign([
            'id' => $container->Id,
            'name' => $container->Name
        ]);
    }
}