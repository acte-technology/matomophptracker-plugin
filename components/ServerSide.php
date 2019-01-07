<?php namespace Acte\MatomoPhpTracker\Components;

use Cms\Classes\ComponentBase;
use Acte\MatomoPhpTracker\Classes\PiwikTracker;
use Acte\MatomoPhpTracker\Models\Settings;

use Log;
use BackendAuth;
use Auth;

class ServerSide extends \Cms\Classes\ComponentBase
{
  public function componentDetails()
  {
    return [
      'name' => 'acte.matomophptracker::lang.components.serverside.name',
      'description' => 'acte.matomophptracker::lang.components.serverside.description'
    ];
  }

  protected $urlSite;
  protected $idSite;
  protected $tokenAuth;


  public function getSettings(){

    $trackerEnable = Settings::get('is_enable', false);
    if(!$trackerEnable){
      return false;
    }

    $this->urlSite = Settings::get('url', false);
    if(!$this->urlSite){
      Log::error('acte.matomophptracker::lang.components.serverside.set-site-url');
      return false;
    }

    $this->idSite = Settings::get('siteid', false);
    if(!$this->idSite){
      Log::error('acte.matomophptracker::lang.components.serverside.set-site-id');
      return false;
    }

    $this->tokenAuth = Settings::get('token', false);
    if(!$this->tokenAuth){
      Log::error('acte.matomophptracker::lang.components.serverside.set-token');
      return false;
    }

    PiwikTracker::$URL = $this->urlSite;
    return true;

  }


  public function onRun(){

    //get settings
    $settings = $this->getSettings();
    if($settings === false){ return false; }

    $loggedIn = BackendAuth::check();
    if($loggedIn){ return false; }

    //init connection
    $piwikTracker = new PiwikTracker( $idSite = $this->idSite );
    $piwikTracker->setTokenAuth($this->tokenAuth);

    //setip mandatory if behind a proxy!
    $ip = $this->getClientIp();
    //Log::debug(['matomo-tracker-ip' => $ip]);
    $piwikTracker->setIp("$ip");

    //logged user if any
    $user = $this->getUserInfos();
    if($user){ $piwikTracker->setUserId($user->email); }

    //send tracking with current page
    $piwikTracker->doTrackPageView(basename($_SERVER['PHP_SELF']));

  }

  public function getClientIp(){
  	if 	(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
  	elseif 	(isset($_SERVER['REMOTE_ADDR'])){
      $clientIp = $_SERVER['REMOTE_ADDR'];
    }

    //validate ip format
  	if (! filter_var($clientIp, FILTER_VALIDATE_IP)){ return false; }

    return $clientIp;
  }

  /*
  getUserInfos requires Auth class to work.
  if Auth class doesn't exists (Rainlab.User plugin not installed), return false.
  */
  public function getUserInfos(){

    if(class_exists('Auth')){

      $loggedIn = Auth::check();
      if($loggedIn){ $user = Auth::getUser();
        if($user){
          return $user;
        }
      }
    }

    return false;

  }


}
