# Description

Server side Matomo tracker using php class PiwikTracker: https://matomo.org/docs/tracking-api/

* Read advantages and inconvenients of a server side tracking system on http://matomo.org
* Tracking is automatically disabled when backend user is connected.
* If Rainlab.User is installed, user id will be passed to Matomo.
* API tracker middleware

# Settings

Set url, siteid and token from your matomo analytics server.

# Usage

* Simply add ServerSide component to your layout or page.

To know more about PHP Tracker PHP class:
* https://developer.matomo.org/api-reference/PHP-Piwik-Tracker

# Api middleware

* Track API calls with ApiTracker middleware

```php
// routes.php exemple

Route::group([
    'middleware' => 'Acte\MatomoPhpTracker\Middlewares\ApiTracker'
  ], function () {

    Route::get('/api/test', function(){ return Response::json(['success' => true]); });

  }
);
```


# Bugs/Improvement

Please report and post improvement suggestions here: https://github.com/acte-solutions/matomophptracker-plugin/issues.
