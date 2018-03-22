<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 31.10.17
 * Time: 17:02
 */

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