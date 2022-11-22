# Castlegate IT WP Cookie Consent

Castlegate IT WP Cookie Consent is a simple plugin wrapper for [Cookie Consent by Osano](https://cookieconsent.osano.com/). You can edit the options via a WordPress filter. For example:

~~~ php
add_filter('cgit_cookie_consent_options', function ($options) {
    $options['palette']['popup']['background'] = '#000';

    return $options;
});
~~~

You can also edit the `status` and `hasTransition` static options:

~~~ php
add_filter('cgit_cookie_consent_static_options', function ($options) {
    $options['status'] = ['deny' => 'deny'];
    $options['hasTransition'] = false;

    return $options;
});
~~~

Please refer to the [Cookie Consent documentation](https://www.osano.com/cookieconsent/documentation/javascript-api/) for a complete list of options.

## Popup location

From version 2.1, this plugin overrides the default Cookie Consent configuration to place the consent popup at the end of the document body. To revert to the original behaviour, where the popup is inserted as the first element in the document body, set the `autoAttach` option to `true`:

~~~ php
add_filter('cgit_cookie_consent_options', function ($options) {
    $options['autoAttach'] = true;

    return $options;
});
~~~

## Development

All the CSS and JavaScript files required by this plugin are bundled in this repository. However, if you want to update or make changes them, you will need to install the third-party dependencies with npm:

    npm install

Then update the packages and/or edit gulpfile.js to make changes to the styles and scripts provided by this plugin.

## License

Released under the [MIT License](https://opensource.org/licenses/MIT). See [LICENSE](LICENSE) for details.
