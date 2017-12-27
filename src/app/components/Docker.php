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
     * @param array $parameters
     * @return string
     */
    public static function generateBody(array $parameters): string
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

        $from = (array_key_exists('from', $parameters) && $parameters['from']) ? 'FROM ' . $parameters['from']
            : null;
        $run = array_key_exists('run', $parameters) ? $processMultistringCommands('RUN', $parameters['run'])
            : null;
        $cmd = (array_key_exists('cmd', $parameters) && $parameters['cmd']) ? 'CMD ' . $parameters['cmd'] : null;
        $expose = (array_key_exists('expose', $parameters) && $parameters['expose'])
            ? 'EXPOSE ' . $parameters['expose'] : null;
        $env = array_key_exists('env', $parameters) ? $processMultistringCommands('ENV', $parameters['env'])
            : null;
        $add = array_key_exists('add', $parameters) ? $processMultistringCommands('ADD', $parameters['add'])
            : null;
        $copy = array_key_exists('copy', $parameters)
            ? $processMultistringCommands('COPY', $parameters['copy']) : null;

        $volume = null;
        if (array_key_exists('volume', $parameters) && $parameters['volume']) {
            $volumeValues = explode(',', $parameters['volume']);
            $volume = array_map(function ($item) {
                return "\"$item\"";
            }, $volumeValues);
            $volume = 'VOLUME [' . implode(',', $volume) . ']';
        }

        $workdir = (array_key_exists('workdir', $parameters) && $parameters['workdir']) ? 'WORKDIR ' . $parameters['workdir'] : '';

        $resultString = array_filter([$from, $workdir, $run, $cmd, $expose, $env, $add, $copy, $volume], function ($item) {
            return $item !== null;
        });

        return implode("\n", $resultString);
    }
}