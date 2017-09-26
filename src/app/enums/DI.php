<?php
/**
 * The information contained in this document is the proprietary and exclusive property
 * of COMODO except as otherwise indicated. No part of this document, in whole or in part,
 * may be reproduced, stored, transmitted, or used for design purposes without the
 * prior written permission of COMODO.
 *
 * The information contained in this document is subject to change without notice.
 *
 * The information in this document is provided for informational purposes only. COMODO
 * specifically disclaims all warranties, express or limited, including, but not limited, to
 * the implied warranties of merchantability and fitness for a particular purpose, except
 * as provided for in a separate software license agreement.
 *
 *
 * This document may contain information of a sensitive nature. This information
 * should not be given to persons other than those who are involved in the project
 * or who will become involved during the lifecycle
 *
 * @author: Vladyslav Pozdnyakov <vladyslav.pozdnyakov@comodo.od.ua>
 * @created: 16.08.17 16:50
 * @copyright COMODO 2017
 */

namespace Dockent\enums;

/**
 * Class DI
 * @package Dockent\enums
 */
final class DI
{
    const DISPATCHER = 'dispatcher';
    const VIEW = 'view';
    const CONFIG = 'config';
    const DOCKER = 'docker';
    const QUEUE = 'queue';
}