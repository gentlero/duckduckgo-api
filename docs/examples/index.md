---
layout: default
permalink: /examples/
title: Examples
---

# Usage examples

**TIP:** Although all examples from this documentation are instantiating each class, a single point of entry is also
available:

```php
$ddg      = new \DDG\API\Api();
$result   = json_decode($ddg->api('Disambiguation')->get('apple')->getContent(), true);
```

### Response format

DuckDuckGo API supports JSON and XML responses. In order to switch the response format, you can use `setFormat()`
method:

```php
$topic  = new \DDG\API\Topic();
$result = $topic->setFormat('xml')->getSummary('valley forge national park');
```

### Listeners

In order to facilitate some tasks, a few listeners are available:

#### JsonBodyListener:

Will decode a JSON response for you.

```php
<?php

use DDG\API\Api;
use DDG\API\Http\Listener\JsonBodyListener;

$ddg    = new Api();
$ddg->getClient()->addListener(new JsonBodyListener());

/** @var \stdClass $result */
$result = $ddg->api('Disambiguation')->get('apple')->getContent();
```


### Available examples

  - [Bang](bang.html)
  - [Categories](categories.html)
  - [Disambiguation](disambiguation.html)
  - [Topic](topic.html)
