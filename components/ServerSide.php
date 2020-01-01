<?php namespace Acte\MatomoPhpTracker\Components;

use Cms\Classes\ComponentBase;
use Acte\MatomoPhpTracker\Classes\TrackerHelper;


class ServerSide extends \Cms\Classes\ComponentBase
{
  public function componentDetails()
  {
    return [
      'name' => 'acte.matomophptracker::lang.components.serverside.name',
      'description' => 'acte.matomophptracker::lang.components.serverside.description'
    ];
  }

  public function onRun(){

    //init tracker
    $trackerHelper = new TrackerHelper;
    $tracker = $trackerHelper->initTracker();

    trace_log($tracker);
    //send page tracking
    if($tracker){ $tracker->doTrackPageView(basename($_SERVER['PHP_SELF'])); }

  }


}
