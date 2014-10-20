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
class Bang extends Api
{
    /**
     * @access public
     * @param  string           $query
     * @return MessageInterface
     *
     * @throws \Exception
     */
    public function get($query)
    {
        if ($query[0] != '!') {
            $query = '!'.$query;
        }

        $this->getClient()->getTransport()->setMaxRedirects(0);

        return $this->getClient()->get('/', array('q' => $query));
    }
}
