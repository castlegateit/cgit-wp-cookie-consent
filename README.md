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

Copyright (c) 2019 Castlegate IT. All rights reserved.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.

### Cookie Consent

This plugin relies on Cookie Consent by Insites, which is released under the MIT License. Please see the [source repository](https://github.com/insites/cookieconsent) for more details.
