<?php namespace Acte\MatomoPhpTracker\Middlewares;

use Closure;
use Acte\MatomoPhpTracker\Classes\TrackerHelper;

class ApiTracker
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {

      //init tracker
      $trackerHelper = new TrackerHelper;
      $tracker = $trackerHelper->initTracker();

      //send page tracking
      if($tracker){ $tracker->doTrackPageView(basename($_SERVER['PHP_SELF'])); }

    }
}
