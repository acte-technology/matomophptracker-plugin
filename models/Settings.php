<?php namespace Acte\MatomoPhpTracker\Models;

use Model;

/**
 * Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'acte_matomophptracker_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
      'url' => 'url',
      'siteid' => 'numeric',
      'token' => 'string|max:255',
    ];

}
