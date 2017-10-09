<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 14:44
 */

namespace Dockent\components;

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
        system("docker pull $image");
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

        $from = $parameters['from'] ? 'FROM ' . $parameters['from'] : null;
        $maintainer = $parameters['maintainer'] ? 'LABEL maintainer=' . $parameters['maintainer'] : null;
        $run = $processMultistringCommands('RUN', $parameters['run']);
        $cmd = $parameters['cmd'] ? 'CMD ' . $parameters['cmd'] : null;
        $expose = $parameters['expose'] ? 'EXPOSE ' . $parameters['expose'] : null;
        $env = $processMultistringCommands('ENV', $parameters['env']);
        $add = $processMultistringCommands('ADD', $parameters['add']);
        $copy = $processMultistringCommands('COPY', $parameters['copy']);

        $volume = null;
        if ($parameters['volume']) {
            $volumeValues = explode(',', $parameters['volume']);
            $volume = array_map(function ($item) {
                return "\"$item\"";
            }, $volumeValues);
            $volume = 'VOLUME [' . implode(',', $volume) . ']';
        }

        $workdir = $parameters['workdir'] ? 'WORKDIR ' . $parameters['workdir'] : '';

        $resultString = array_filter([$from, $maintainer, $workdir, $run, $cmd, $expose, $env, $add, $copy, $volume], function ($item) {
            return $item !== null;
        });

        return implode("\n", $resultString);
    }
}