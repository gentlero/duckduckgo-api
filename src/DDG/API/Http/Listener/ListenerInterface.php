<?php

/**
 * This file is part of the duckduckgo-api package.
 *
 * (c) Alexandru Guzinschi <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DDG\API\Http\Listener;

use Buzz\Listener\ListenerInterface as BaseInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
interface ListenerInterface extends BaseInterface
{
    /**
     * Get listener (unique) name
     *
     * @access public
     * @return string
     */
    public function getName();
}
