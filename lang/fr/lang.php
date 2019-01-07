<?php return [
    'plugin' => [
        'name' => 'MatomoPhpTracker',
        'description' => 'Tracking analytique coté serveur utilisant Matomo PHP (Piwik)'
    ],

    'settings' => [
      'title' => 'Paramètres Matomo',
      'enable_tracker' => 'Activer le tracker',
      'matomo_url' => 'URL de Matomo',
      'site_id' => 'Site ID',
      'site_id_description' => 'ID du site: https://matomo.org/faq/general/faq_19212/',
      'token' => 'Jeton',
      'token_description' => "Jeton d'authentification fourni par Matomo",
    ],

    'components' => [
      'serverside' => [
        'name' => 'Tracking coté serveur',
        'description' => 'Activer Matomo coté serveur',
        'set-site-url' => 'URL du serveur Matomo manquant dans les paramètres de configuration',
        'set-site-id' => 'ID du site web manquant dans les paramètres de configuration',
        'set-token' => "Le jeton d'authentification à Matomo est manquant dans les paramètres de configuration",
      ],
    ],  

];
