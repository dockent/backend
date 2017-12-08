<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 05.12.17
 * Time: 16:52
 */

namespace Dockent\models;

use Dockent\components\FormModel;
use Phalcon\Validation\Validator\Callback;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Class BuildImageByDockerfilePath
 * @package Dockent\models
 */
class BuildImageByDockerfilePath extends FormModel
{
    /**
     * @var string
     */
    protected $dockerfilePath = '';

    public function rules()
    {
        $this->validator->add(['dockerfilePath'], new PresenceOf());
        $this->validator->add(['dockerfilePath'], new Callback([
            'callback' => function ($data): bool {
                return is_dir($data) && file_exists($data . DIRECTORY_SEPARATOR . 'Dockerfile');
            },
            'message' => 'Dockerfile not found'
        ]));
    }

    /**
     * @return string
     */
    public function getDockerfilePath(): string
    {
        return $this->dockerfilePath;
    }

    /**
     * @param string $dockerfilePath
     */
    public function setDockerfilePath(string $dockerfilePath): void
    {
        $this->dockerfilePath = $dockerfilePath;
    }
}