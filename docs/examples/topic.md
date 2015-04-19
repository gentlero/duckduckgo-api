---
layout: default
permalink: /examples/topic.html
title: Topic
---

# Topic

## JSON response

```php
$topic = new \DDG\API\Topic();
$result = $topic->getSummary('valley forge national park');
```

_Response example is available [here](http://api.duckduckgo.com/?q=valley+forge+national+park&format=json&pretty=1)._

---

#### Related:
  * [Response format]({{ site.url }}/examples/index.html#response-format)
  * [Listeners]({{ site.url }}/examples/index.html#listeners)
