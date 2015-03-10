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

use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

/**
 * Decode JSON from response body.
 *
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class JsonBodyListener implements ListenerInterface
{
    /**
     * {@inheritDoc}
     */
    public function preSend(RequestInterface $request)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function postSend(RequestInterface $request, MessageInterface $response)
    {
        if (mb_strlen($response->getContent()) > 0) {
            $data = json_decode($response->getContent());

            if (JSON_ERROR_NONE === json_last_error()) {
                $response->setContent($data);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'json_body';
    }
}
