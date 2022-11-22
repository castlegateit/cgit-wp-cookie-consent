<?php

namespace Cgit\CookieConsent;

class Plugin
{
    /**
     * Plugin file path
     *
     * @var string
     */
    private $plugin = '';

    /**
     * Script file path relative to plugin directory
     *
     * @var string
     */
    private $script = 'dist/js/script.min.js';

    /**
     * Style file path relative to plugin directory
     *
     * @var string
     */
    private $style = 'dist/css/style.min.css';

    /**
     * Script name
     *
     * @var string
     */
    private $name = '';

    /**
     * Cookie Consent configuration
     *
     * See <https://cookieconsent.osano.com/documentation/javascript-api/> for
     * full documentation.
     *
     * @var array
     */
    private $options = [
        'palette' => [
            'popup' => [
                'background' => '#000',
            ],
            'button' => [
                'background' => '#fff',
            ],
        ],
        'autoAttach' => true,
    ];

    /**
     * Cookie Consent static configuration
     *
     * See <https://www.osano.com/cookieconsent/documentation/javascript-api/>
     *
     * @var array
     */
    private $staticOptions = [
        'hasTransition' => false,
    ];

    /**
     * Construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->plugin = CGIT_COOKIE_CONSENT_PLUGIN;
        $this->name = pathinfo($this->plugin, PATHINFO_FILENAME);

        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }

    /**
     * Enqueue scripts
     *
     * @return void
     */
    public function enqueue()
    {
        $dir = dirname($this->plugin);
        $url = plugin_dir_url($this->plugin);

        // Files do not exist? Enqueue legacy third-party scripts.
        if (!file_exists(path_join($dir, $this->script)) ||
            !file_exists(path_join($dir, $this->style))) {
            return $this->enqueueLegacyScripts();
        }

        // Enqueue local scripts
        wp_enqueue_script($this->name, path_join($url, $this->script), null, null, true);
        wp_enqueue_style($this->name, path_join($url, $this->style), null, null);

        $this->insertInitScript();
    }

    /**
     * Enqueue legacy hosted scripts
     *
     * If the Cookie Consent submodule is missing, possibly because the plugin
     * has been updated in place, this ensures that the third-party scripts are
     * enqueued as they were in version 1.0 of this plugin.
     *
     * @return void
     */
    public function enqueueLegacyScripts()
    {
        $style = '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css';
        $script = '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js';

        wp_enqueue_script($this->name, $script, null, null);
        wp_enqueue_style($this->name, $style, null, null);

        $this->insertInitScript();
    }

    /**
     * Insert initialization script
     *
     * If the autoAttach option is false, the popup is inserted as the last
     * element in the document body. Otherwise, the popup is inserted
     * automatically as the first element.
     *
     * @return void
     */
    public function insertInitScript()
    {
        $this->options = apply_filters('cgit_cookie_consent_options', $this->options);
        $this->staticOptions = apply_filters('cgit_cookie_consent_static_options', $this->staticOptions);

        $options = json_encode($this->options);
        $static_options = '';

        // Set status option?
        if (isset($this->staticOptions['status'])) {
            $static_options .= sprintf(
                'window.cookieconsent.status = %s;',
                json_encode($this->staticOptions['status'])
            );
        }

        // Set transition option?
        if (isset($this->staticOptions['hasTransition'])) {
            $static_options .= sprintf(
                'window.cookieconsent.hasTransition = %s;',
                $this->staticOptions['hasTransition'] ? 'true' : 'false'
            );
        }

        // Load automatically (default behaviour) or on window load, depending
        // on the value of the autoAttach option.
        if ($this->options['autoAttach'] ?? true) {
            $code = sprintf('%s window.cookieconsent.initialise(%s);', $static_options, $options);
        } else {
            $code = sprintf('window.addEventListener("load", function () {
                %s

                window.cookieconsent.initialise(%s, function (instance) {
                    if (instance.options.autoAttach) {
                        return;
                    }

                    document.body.appendChild(instance.element);
                });
            });', $static_options, $options);
        }

        // Print script.
        wp_add_inline_script($this->name, $code);
    }
}
