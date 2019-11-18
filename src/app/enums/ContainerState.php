<?php

namespace Dockent\enums;

/**
 * Class ContainerState
 * @package Dockent\enums
 */
abstract class ContainerState
{
    const RUNNING = 'running';
    const CREATED = 'created';
    const RESTARTING = 'restarting';
    const REMOVING = 'removing';
    const PAUSED = 'paused';
    const EXITED = 'exited';
    const DEAD = 'dead';
}