<?php return [
    'plugin' => [
        'name' => 'MatomoPhpTracker',
        'description' => 'Server side analytics tracking using Matomo'
    ],

    'settings' => [
      'title' => 'Matomo settings',
      'enable_tracker' => 'Enable tracker',
      'matomo_url' => 'Matomo URL',
      'site_id' => 'Site ID',
      'site_id_description' => 'Website id: https://matomo.org/faq/general/faq_19212/',
      'token' => 'Token',
      'token_description' => 'Authentication token provided by Matomo',
    ],

    'components' => [
      'serverside' => [
        'name' => 'Server side tracking',
        'description' => 'Enable Matomo from server side.',
        'set-site-url' => 'Please set site URL in backend settings',
        'set-site-id' => 'Please set site URL in backend settings',
        'set-token' => 'Please set token in backend settings',
      ],

    ],

];
