# Castlegate IT WP Cookie Consent

Castlegate IT WP Cookie Consent is a simple plugin wrapper for [Cookie Consent by Osano](https://cookieconsent.osano.com/). You can edit the options via a WordPress filter. For example:

~~~ php
add_filter('cgit_cookie_consent_options', function ($options) {
    $options['palette']['popup']['background'] = '#000';

    return $options;
});
~~~

Please refer to the [Cookie Consent documentation](https://cookieconsent.osano.com/documentation/javascript-api/) for a complete list of options.

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

Copyright (c) 2019 Castlegate IT. All rights reserved.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.

### Cookie Consent

This plugin relies on Cookie Consent by Insites, which is released under the MIT License. Please see the [source repository](https://github.com/insites/cookieconsent) for more details.
