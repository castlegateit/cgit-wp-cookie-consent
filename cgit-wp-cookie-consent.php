<?php

/*

Plugin Name: Castlegate IT WP Cookie Consent
Plugin URI: https://github.com/castlegateit/cgit-wp-cookie-consent
Description: Plugin wrapper for Cookie Consent by Insites
Version: 2.0
Author: Castlegate IT
Author URI: https://www.castlegateit.co.uk/
Network: true

Copyright (c) 2019 Castlegate IT. All rights reserved.

*/

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

define('CGIT_COOKIE_CONSENT_PLUGIN', __FILE__);

require_once __DIR__ . '/classes/autoload.php';

$plugin = new \Cgit\CookieConsent\Plugin;

do_action('cgit_cookie_consent_plugin', $plugin);
do_action('cgit_cookie_consent_loaded');
