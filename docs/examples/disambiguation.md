---
layout: default
permalink: /examples/disambiguation.html
title: Disambiguation
---

# Disambiguation

## JSON response

```php
$disambiguation = new \DDG\API\Disambiguation();
$result = $disambiguation->get('apple');
```

_Response example is available [here](http://api.duckduckgo.com/?q=apple&format=json&pretty=1)._


---

#### Related:
  * [Response format]({{ site.url }}/examples/index.html#response-format)
  * [Listeners]({{ site.url }}/examples/index.html#listeners)
