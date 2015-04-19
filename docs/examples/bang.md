---
layout: default
permalink: /examples/bang.html
title: Bang
---

# Bang

!bangs are shortcuts that start with an exclamation point like, !wikipedia and !espn. Use them to quickly search other
sites from the DuckDuckGo search box.

You can view a list of available !bang commands [here](https://duckduckgo.com/bang.html).

## JSON response

```php
$bang = new \DDG\API\Bang();
$result = $bang->get('imdb rushmore');
```

_Response example is available [here](http://api.duckduckgo.com/?q=!imdb+rushmore&format=json&pretty=1&no_redirect=1)._

---

#### Related:
  * [Response format]({{ site.url }}/examples/index.html#response-format)
  * [Listeners]({{ site.url }}/examples/index.html#listeners)
