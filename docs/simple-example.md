# Simple example

~~~ php
<?php

use DDG\API\Disambiguation;

$disambiguation = new Disambiguation()
$result = json_decode($disambiguation->get('apple')->getContent(), true);
~~~

As an alternative, you can also use `api()` method to get an instance of child class:

~~~ php
<?php

use DDG\API\Api;

$ddg    = new Api();
$result = json_decode($ddg->api('Disambiguation')->get('apple')->getContent(), true);
~~~

You can also register the `JsonBodyListener` which will decode JSON responses for you:

~~~ php
<?php

use DDG\API\Api;
use DDG\API\Http\Listener\JsonBodyListener;

$ddg    = new Api();
$ddg->getClient()->addListener(new JsonBodyListener());

/** @var \stdClass $result */
$result = $ddg->api('Disambiguation')->get('apple')->getContent();
~~~

You can view a response sample for disambiguation [here][1].

[1]: http://api.duckduckgo.com/?q=apple&format=json&pretty=1
