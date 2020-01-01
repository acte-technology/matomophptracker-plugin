<?php namespace Acte\MatomoPhpTracker\Classes;

use Acte\MatomoPhpTracker\Classes\PiwikTracker;
use Acte\MatomoPhpTracker\Models\Settings;

use Log;
use Auth;
use BackendAuth;

class TrackerHelper
{


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


  /**
    * Get client IP address
  **/
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

  /**
    * Get OctoberCMS Settings
  **/
  public function getSettings(){

    $trackerEnable = Settings::get('is_enable', false);
    if(!$trackerEnable){
      return null;
    }

    $urlSite = Settings::get('url', false);
    if(!$urlSite){
      Log::error('acte.matomophptracker::lang.components.serverside.set-site-url');
      return null;
    }

    $idSite = Settings::get('siteid', false);
    if(!$idSite){
      Log::error('acte.matomophptracker::lang.components.serverside.set-site-id');
      return null;
    }

    $tokenAuth = Settings::get('token', false);
    if(!$tokenAuth){
      Log::error('acte.matomophptracker::lang.components.serverside.set-token');
      return null;
    }


    return [
      'trackerEnable' => $trackerEnable,
      'urlSite' => $urlSite,
      'idSite' => $idSite,
      'tokenAuth' => $tokenAuth
    ];

  }

  public function initTracker(){

    if( BackendAuth::check() === true ){ return null; }

    //get settings
    $settings = $this->getSettings();
    if($settings === null){ return null; }



    PiwikTracker::$URL = $settings['urlSite'];
    $piwikTracker = new PiwikTracker( $idSite = $settings['idSite'] );
    $piwikTracker->setTokenAuth($settings['tokenAuth']);

    //setip mandatory if behind a proxy!
    $ip = $this->getClientIp();
    $piwikTracker->setIp("$ip");

    //logged user if any
    $user = $this->getUserInfos();
    if($user){ $piwikTracker->setUserId($user->email); }


    return $piwikTracker;

  }




}
