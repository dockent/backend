<?php

namespace Dockent\components\docker;

use Dockent\models\DockerfileBuilder;

/**
 * Class BodyGenerator
 * @package Dockent\components\docker
 */
class BodyGenerator
{
    /**
     * @param DockerfileBuilder $parameters
     * @return string
     */
    public function generateBody(DockerfileBuilder $parameters): string
    {
        $from = $parameters->getFrom() ? 'FROM ' . $parameters->getFrom() : null;
        $run = $parameters->getRun() ? static::processMultistringCommands('RUN', $parameters->getRun()) : null;
        $cmd = $parameters->getCmd() ? 'CMD ' . $parameters->getCmd() : null;
        $expose = $parameters->getExpose() ? 'EXPOSE ' . $parameters->getExpose() : null;
        $env = $parameters->getEnv() ? static::processMultistringCommands('ENV', $parameters->getEnv()) : null;
        $add = $parameters->getAdd() ? static::processMultistringCommands('ADD', $parameters->getAdd()) : null;
        $copy = $parameters->getCopy() ? static::processMultistringCommands('COPY', $parameters->getCopy()) : null;

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

    /**
     * @param string $prefix
     * @param string $commands
     * @return string
     */
    private function processMultistringCommands(string $prefix, string $commands): string
    {
        $commands = explode("\n", $commands);
        $map = [];
        if (!empty($commands)) {
            $map = array_map(function ($item) use ($prefix) {
                return "$prefix $item";
            }, $commands);
        }
        return implode("\n", $map);
    }
}