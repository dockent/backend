<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 05.12.17
 * Time: 17:02
 */

namespace Dockent\models;

use Dockent\components\FormModel;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Class BuildImageByDockerfileBody
 * @package Dockent\models
 */
class BuildImageByDockerfileBody extends FormModel
{
    /**
     * @var string
     */
    protected $dockerfileBody = '';

    public function rules()
    {
        $this->validator->add(['dockerfileBody'], new PresenceOf());
    }

    /**
     * @return string
     */
    public function getDockerfileBody(): string
    {
        return $this->dockerfileBody;
    }

    /**
     * @param string $dockerfileBody
     */
    public function setDockerfileBody(string $dockerfileBody)
    {
        $this->dockerfileBody = $dockerfileBody;
    }
}