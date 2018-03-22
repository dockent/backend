<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

namespace Dockent\enums;

/**
 * Class DI
 * @package Dockent\enums
 */
abstract class DI
{
    const DISPATCHER = 'dispatcher';
    const VIEW = 'view';
    const CONFIG = 'config';
    const DOCKER = 'docker';
    const QUEUE = 'queue';
    const ANNOTATIONS = 'annotations';
    const LOGGER = 'logger';
    const REQUEST = 'request';
    const EVENTS_MANAGER = 'eventsManager';
    const DB = 'db';
}