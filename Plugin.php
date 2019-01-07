<?php namespace Acte\MatomoPhpTracker;

use System\Classes\PluginBase;
use Acte\MatomoPhpTracker\Classes\PiwikTracker;


class Plugin extends PluginBase
{
  public function registerComponents()
  {
    return [
      'Acte\MatomoPhpTracker\Components\ServerSide' => 'serverside',
    ];
  }

  public function registerSettings()
  {
    return [
      'settings' => [
        'label'       => 'acte.matomophptracker::lang.settings.title',
        'description' => 'acte.matomophptracker::lang.plugin.description',
        'category'    => 'Matomo',
        'icon'        => 'icon-cog',
        'class'       => 'Acte\MatomoPhpTracker\Models\Settings',
        'order'       => 500,
        'keywords'    => 'piwik matomo tracker',
        'permissions' => ['acte.matomophptracker.manage_settings']
    ]
    ];
  }

  public function boot(){

  }
}
