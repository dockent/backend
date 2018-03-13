<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 14:44
 */

namespace Dockent\components;

use Dockent\components\DI as DIFactory;
use Dockent\Connector\Connector;
use Dockent\enums\DI;
use Dockent\models\DockerfileBuilder;

/**
 * Class Docker
 * @package Dockent\components
 */
abstract class Docker
{
    /**
     * @param string $image
     */
    public static function pull(string $image)
    {
        $image = explode(':', $image);
        $parameters = [];
        if (count($image) === 1) {
            $parameters['fromImage'] = $image[0];
            $parameters['tag'] = 'latest';
        } else {
            $parameters['fromImage'] = $image[0];
            $parameters['tag'] = $image[1];
        }
        /** @var Connector $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->ImageResource()->imageCreate(null, $parameters);
    }

    /**
     * @param DockerfileBuilder $parameters
     * @return string
     */
    public static function generateBody(DockerfileBuilder $parameters): string
    {
        $processMultistringCommands = function (string $prefix, string $commands): string {
            $commands = explode("\n", $commands);
            $map = [];
            if (!empty($commands)) {
                $map = array_map(function ($item) use ($prefix) {
                    return "$prefix $item";
                }, $commands);
            }
            return implode("\n", $map);
        };

        $from = $parameters->getFrom() ? 'FROM ' . $parameters->getFrom() : null;
        $run = $parameters->getRun() ? $processMultistringCommands('RUN', $parameters->getRun()) : null;
        $cmd = $parameters->getCmd() ? 'CMD ' . $parameters->getCmd() : null;
        $expose = $parameters->getExpose() ? 'EXPOSE ' . $parameters->getExpose() : null;
        $env = $parameters->getEnv() ? $processMultistringCommands('ENV', $parameters->getEnv()) : null;
        $add = $parameters->getAdd() ? $processMultistringCommands('ADD', $parameters->getAdd()) : null;
        $copy = $parameters->getCopy() ? $processMultistringCommands('COPY', $parameters->getCopy()) : null;

        $volume = null;
        if ($parameters->getVolume()) {
            $volumeValues = explode(',', $parameters->getVolume());
            $volume = array_map(function ($item) {
                return "\"$item\"";
            }, $volumeValues);
            $volume = 'VOLUME [' . implode(',', $volume) . ']';
        }

        $workdir = $parameters->getWorkdir() ? 'WORKDIR ' . $parameters->getWorkdir() : null;

        $resultString = array_filter([$from, $workdir, $run, $cmd, $expose, $env, $add, $copy, $volume], function ($item) {
            return $item !== null;
        });

        return implode("\n", $resultString);
    }
}