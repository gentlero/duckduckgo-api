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

use DDG\API\Http\Client;
use DDG\API\Http\ClientInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class Api
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    public function __construct()
    {
        $this->setClient(new Client());
    }

    /**
     * @access public
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->httpClient;
    }

    /**
     * @access public
     * @param  ClientInterface $client
     * @return $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Set the preferred format for response
     *
     * @access public
     * @param  string $name Format name
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setFormat($name)
    {
        $this->getClient()->setResponseFormat($name);

        return $this;
    }

    /**
     * Get current format used for response
     *
     * @access public
     * @return string
     */
    public function getFormat()
    {
        return $this->getClient()->getResponseFormat();
    }

    /**
     * @access public
     * @param  string $name
     * @return $this
     *
     * @see https://duck.co/help/privacy/t
     */
    public function setAppName($name)
    {
        $this->getClient()->setOption('app_name', (string) $name);

        return $this;
    }

    /**
     * @access public
     * @return string
     *
     * @see https://duck.co/help/privacy/t
     */
    public function getAppName()
    {
        return $this->getClient()->getOption('app_name');
    }

    /**
     * @access public
     * @param  string $name
     * @return Api
     *
     * @throws \InvalidArgumentException If $name is empty
     * @throws \Exception                If child class does not exist.
     */
    public function api($name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('No child specified.');
        }

        /** @var Api $child */
        $class  = '\\DDG\\API\\'.$name;

        if (!class_exists($class)) {
            throw new \Exception(sprintf('Class %s does not exist.', $class));
        }

        $child  = new $class();

        $child->setClient($this->getClient());

        if ($this->getClient()->hasListeners()) {
            $child->getClient()->setListeners($this->getClient()->getListeners());
        }

        return $child;
    }
}
