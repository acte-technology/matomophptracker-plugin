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
      'consent' => [
        'consent_mode' => 'Activate Consent Mode',
        'disable_cookies' => 'Deactivate cookies and use only fingerprint (settings below will be ignored if checked)',
        'allow_cookies' => 'Allow cookies after consent',
        'http_cookies' => 'Set server-side cookies as "httpOnly"',
        'secure_cookies' => 'Set server-side cookies as "secure"',
        'samesite_cookies' => 'Set SameSite attribute for server-side cookies to "Strict"',
        'consent_cookie_name' => 'Name of the cookie where consent is stored',
        'consent_cookie_value' => 'Value of the cookie  after consent was granted',
        'comments' => [
          'disable_comment' => 'Disable all cookies by the MatomoPhpTracker and use only fingerprinting: https://matomo.org/faq/general/faq_157/.',
          'enable_comment' => 'Enter a cookie containing the consent information and let Matomo set cookies based on this info.',
        ],
      ],
      'section' => [
        'section_consent' => 'Configure cookie behavior',
        'section_fingerprint' => 'Use the MatomoPhpTracker with fingerprint identification of the user only',
        'section_cookie' => 'Configure server-side cookies set by MatomoPhpTracker',
      ],
      'tabs' => [
        'config' => 'Configuration',
        'consent' => 'Consent'
      ],
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
