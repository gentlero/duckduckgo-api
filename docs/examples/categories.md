---
layout: default
permalink: /examples/categories.html
title: Categories
---

# Categories

## JSON response

```php
$categories = new \DDG\API\Categories();
$result = $categories->get('simpsons characters');
```

_Response example is available [here](http://api.duckduckgo.com/?q=simpsons+characters&format=json&pretty=1)._

---

#### Related:
  * [Response format]({{ site.url }}/examples/index.html#response-format)
  * [Listeners]({{ site.url }}/examples/index.html#listeners)
