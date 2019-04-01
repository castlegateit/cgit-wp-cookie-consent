# Castlegate IT WP Cookie Consent

Castlegate IT WP Cookie Consent is a simple plugin wrapper for [Cookie Consent by Insite](https://cookieconsent.insites.com/). You can edit the options via a WordPress filter. For example:

~~~ php
add_filter('cgit_cookie_consent_options', function ($options) {
    $options['palette']['popup']['background'] = '#000';

    return $options;
});
~~~

Please refer to the [Cookie Consent documentation](https://cookieconsent.insites.com/documentation/javascript-api/) for a complete list of options.

## License

This plugin is released under the MIT License. It relies on Cookie Consent by Insites, which is also released under the MIT License. Please see the [source repository](https://github.com/insites/cookieconsent) for more details.
