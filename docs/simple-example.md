# Simple example

~~~ php
<?php

use DDG\API\Disambiguation;

$disambiguation = new Disambiguation()
$result = json_decode($disambiguation->get('apple')->getContent(), true);
~~~

You can view a response sample for disambiguation [here][1].

[1]: http://api.duckduckgo.com/?q=apple&format=json&pretty=1
