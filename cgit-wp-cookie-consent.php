<?php

/*

Plugin Name: Castlegate IT WP Cookie Consent
Plugin URI: https://github.com/castlegateit/cgit-wp-cookie-consent
Description: Plugin wrapper for Cookie Consent by Insites
Version: 1.0
Author: Castlegate IT
Author URI: https://www.castlegateit.co.uk/
Network: true

Copyright (c) 2019 Castlegate IT. All rights reserved.

*/

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

add_action('wp_head', function () {
    $options = json_encode(apply_filters('cgit_cookie_consent_options', [
        'palette' => [
            'popup' => [
                'background' => '#1a1a1a',
            ],
            'button' => [
                'background' => '#e6e6e6',
            ],
        ],
    ]));

    ?>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            window.cookieconsent.initialise(<?= $options ?>);
        });
    </script>
    <?php
});
