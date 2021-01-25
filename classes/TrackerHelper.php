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

  /**
   * Get consent options
  **/
  public function getConsentSettings(){

    $consentModeEnable = Settings::get('consent_mode', false);
    if(!$consentModeEnable){
      return null;
    }

    $disableCookies = false;
    $disableCookies = Settings::get('disable_cookies', false);

    $allowCookies = Settings::get('allow_cookies', false);

    if(isset($allowCookies)){
      $consentCookieName = Settings::get('consent_cookie_name', false);
  
      $consentCookieValue = Settings::get('consent_cookie_value', false);
  
      $httpCookies = Settings::get('http_cookies', false);
  
      $secureCookies = Settings::get('secure_cookies', false);
  
      $samesiteCookies = Settings::get('samesite_cookies', false);
    } 

    return [
      'disableCookies' => $disableCookies,
      'allowCookies' => $allowCookies,
      'consentCookieName' => $consentCookieName,
      'consentCookieValue' => $consentCookieValue,
      'httpCookies' => $httpCookies,
      'secureCookies' => $secureCookies,
      'samesiteCookies' => $samesiteCookies
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

    // get consent settings and disable or enable cookies accordingly
    $consentSettings = $this->getConsentSettings();
    if ($consentSettings != null){

      // if Consent Mode is enabled but cookies are not, disable them
      if ($consentSettings['disableCookies']){

        $piwikTracker->disableCookieSupport();

      } 
      // otherwise set cookies according to settings
      else {

        $cookieName = $consentSettings['consentCookieName'];
        $cookieValue = $consentSettings['consentCookieValue'];
        
        if(isset($_COOKIE[$cookieName]) and $consentSettings['allowCookies'] == true) {
  
          $consent = $_COOKIE[$cookieName];
  
          if($consent != $cookieValue){
  
            $piwikTracker->disableCookieSupport();
  
          } 
          else {
  
            $domain = "";
            $path = "/";
            $secure = $consentSettings['httpCookies'];
            $httpOnly = $consentSettings['secureCookies'];
            $sameSite = ($consentSettings['samesiteCookies'] == true ? "Strict" : "None");
            $piwikTracker->enableCookies($domain, $path, $secure, $httpOnly, $sameSite);
  
          }
        } else {
          $piwikTracker->disableCookieSupport();
        }
      }

    }

    // if(isset($_COOKIE['CookieConsent'])) {
    //   $consent = $_COOKIE['CookieConsent'];
    //   if($consent == 0 || $consent == "0"){
    //     $piwikTracker->disableCookieSupport();
    //   } else {
    //       $domain = "";
    //       $path = "/";
    //       $secure = "true";
    //       $httpOnly = "true";
    //       $sameSite = "Strict";
    //       $piwikTracker->enableCookies($domain, $path, $secure, $httpOnly, $sameSite);
    //     }
    // } else {
    //   $piwikTracker->disableCookieSupport();
    // }

    //setip mandatory if behind a proxy!
    $ip = $this->getClientIp();
    $piwikTracker->setIp("$ip");

    //logged user if any
    $user = $this->getUserInfos();
    if($user){ $piwikTracker->setUserId($user->email); }


    return $piwikTracker;

  }




}
