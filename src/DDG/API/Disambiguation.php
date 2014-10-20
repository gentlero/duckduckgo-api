<?php

/**
 * This file is part of the duckduckgo-api package.
 *
 * (c) Alexandru Guzinschi <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DDG\API;

use Buzz\Message\MessageInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class Disambiguation extends Api
{
    /**
     * @access public
     * @param  string           $query
     * @return MessageInterface
     */
    public function get($query)
    {
        return $this->getClient()->get('/', array('q' => $query));
    }
}
