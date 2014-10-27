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

You can view a response sample for disambiguation [here][1].

[1]: http://api.duckduckgo.com/?q=apple&format=json&pretty=1
