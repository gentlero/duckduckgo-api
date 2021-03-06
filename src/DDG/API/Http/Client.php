<?php

/**
 * This file is part of the duckduckgo-api package.
 *
 * (c) Alexandru Guzinschi <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DDG\API\Http;

use Buzz\Client\ClientInterface as BuzzClientInterface;
use Buzz\Client\Curl;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Buzz\Message\Request;
use Buzz\Message\Response;
use DDG\API\Http\Listener\ListenerInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class Client extends ClientListener implements ClientInterface
{
    /**
     * @var array
     */
    protected $options = array(
        'base_url'      => 'https://api.duckduckgo.com',
        'format'        => 'json',
        'formats'       => array('json', 'xml'),    // supported response formats
        'user_agent'    => 'duckduckgo-api-php/0.2.0 (https://github.com/gentlero/duckduckgo-api)',
        'app_name'      => 'my app',
        'timeout'       => 10,
        'verify_peer'   => true
    );

    /**
     * @var BuzzClientInterface
     */
    protected $transport;

    /**
     * @var RequestInterface
     */
    private $lastRequest;

    /**
     * @var MessageInterface
     */
    private $lastResponse;

    /**
     * @var MessageInterface
     */
    protected $responseObj;

    /**
     * @var RequestInterface
     */
    protected $requestObj;

    public function __construct(array $options = array(), BuzzClientInterface $client = null)
    {
        $this->transport    = (is_null($client)) ? new Curl() : $client;
        $this->options      = array_merge($this->options, $options);

        $this->transport->setTimeout($this->options['timeout']);
        $this->transport->setVerifyPeer($this->options['verify_peer']);
    }

    /**
     * {@inheritDoc}
     */
    public function get($endpoint, $params = array(), array $headers = array())
    {
        if (is_array($params) && count($params) > 0) {
            $endpoint   .= (strpos($endpoint, '?') === false ? '?' : '&').http_build_query($params, '', '&');
        }

        return $this->request($endpoint, $params, 'GET', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function post($endpoint, $params = array(), array $headers = array())
    {
        return $this->request($endpoint, $params, 'POST', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function put($endpoint, $params = array(), array $headers = array())
    {
        return $this->request($endpoint, $params, 'PUT', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($endpoint, $params = array(), array $headers = array())
    {
        return $this->request($endpoint, $params, 'DELETE', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function request($endpoint, $params = array(), $method = 'GET', array $headers = array())
    {
        $request    = $this->setRequestData($params, $method, $headers, $this->createRequest($method, $endpoint));
        $response   = is_object($this->responseObj) ? $this->responseObj : new Response();

        $this->executeListeners($request, 'preSend');

        $this->transport->send($request, $response);

        $this->executeListeners($request, 'postSend', $response);

        $this->lastRequest  = $request;
        $this->lastResponse = $response;

        return $response;
    }

    /**
     * @access public
     * @return BuzzClientInterface
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * {@inheritDoc}
     */
    public function getResponseFormat()
    {
        return $this->options['format'];
    }

    /**
     * {@inheritDoc}
     */
    public function setResponseFormat($format)
    {
        if (!in_array($format, $this->options['formats'], true)) {
            throw new \InvalidArgumentException(sprintf('Unsupported response format %s', $format));
        }

        $this->options['format'] = $format;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getApiBaseUrl()
    {
        return $this->options['base_url'];
    }

    /**
     * @access public
     * @return MessageInterface
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @access public
     * @return RequestInterface
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @access public
     * @param  MessageInterface $response
     * @return void
     */
    public function setResponse(MessageInterface $response)
    {
        $this->responseObj = $response;
    }

    /**
     * @access public
     * @param  RequestInterface $request
     * @return void
     */
    public function setRequest(RequestInterface $request)
    {
        $this->requestObj = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getOption($name)
    {
        return array_key_exists($name, $this->options) ? $this->options[$name] : null;
    }

    /**
     * @access protected
     * @param  string           $method
     * @param  string           $url
     * @return RequestInterface
     */
    protected function createRequest($method, $url)
    {
        // do not set base URL if a full one was provided
        if (false === strpos($url, $this->getApiBaseUrl())) {
            $url = $this->getApiBaseUrl().'/'.ltrim($url, '/');
        }

        $request = is_object($this->requestObj) ? $this->requestObj : new Request();
        $request->setMethod($method);
        $request->addHeaders(array(
                'User-Agent' => $this->options['user_agent']
            ));
        $request->setProtocolVersion(1.1);
        $request->fromUrl($url);

        return $request;
    }

    /**
     * @access protected
     * @param  string|array     $params
     * @param  string           $method
     * @param  array            $headers
     * @param  RequestInterface $request
     * @return RequestInterface
     *
     * @throws \InvalidArgumentException
     */
    protected function setRequestData($params, $method, array $headers, RequestInterface $request)
    {
        // add a default content-type if none was set
        if (in_array(strtoupper($method), array('POST', 'PUT'), true) && empty($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        if (count($headers) > 0) {
            $request->addHeaders($headers);
        }

        if (is_array($params)) {
            $params = http_build_query($this->buildQueryData($params));
        }

        if (strpos($params, 'format=json') === false && (
            (strpos($params, 'callback=') !== false) || strpos($params, 'pretty=') !== false)
        ) {
            throw new \InvalidArgumentException("'callback' and 'pretty' options can be used only with JSON format");
        }

        if ('GET' === $method) {
            $request->setResource('/?'.$params);
        } else {
            $request->setContent($params);
        }

        return $request;
    }

    /**
     * Append mandatory parameters to the query
     *
     * @access public
     * @param  array $params
     * @return array
     */
    protected function buildQueryData(array $params)
    {
        /**
         * Add app name if was not already been set
         * @see https://duck.co/help/privacy/t
         */
        if (!array_key_exists('t', $params)) {
            $params['t'] = $this->getOption('app_name');
        }

        if (!array_key_exists('format', $params)) {
            $params['format'] = $this->getResponseFormat();
        }

        return $params;
    }

    /**
     * Execute all available listeners
     *
     * $when can be: preSend or postSend
     *
     * @access protected
     * @param  RequestInterface $request
     * @param  string           $when     When to execute the listener
     * @param  MessageInterface $response
     * @return void
     */
    protected function executeListeners(RequestInterface $request, $when = 'preSend', MessageInterface $response = null)
    {
        if (false === $this->hasListeners()) {
            return;
        }

        $params = array($request);

        if (!is_null($response)) {
            $params[] = $response;
        }

        ksort($this->listeners, SORT_ASC);

        array_walk_recursive(
            $this->listeners,
            function ($class) use ($when, $params) {
                if ($class instanceof ListenerInterface) {
                    call_user_func_array(array($class, $when), $params);
                }
            }
        );
    }
}
