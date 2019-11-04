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
        $this->options = apply_filters('cgit_cookie_consent_options', $this->options);

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
     * The default behaviour is to insert the popup as the first element in the
     * document body. Here, unless this behaviour is explicitly requested by
     * setting autoAttach to true, the popup is inserted as the last element in
     * the document body using a custom function.
     *
     * @return void
     */
    public function insertInitScript()
    {
        if (!isset($this->options['autoAttach'])) {
            $this->options['autoAttach'] = false;
        }

        $code = sprintf('window.addEventListener("load", function () {
            window.cookieconsent.initialise(%s, function (instance) {
                if (instance.options.autoAttach) {
                    return;
                }

                document.body.appendChild(instance.element);
            });
        });', json_encode($this->options));

        wp_add_inline_script($this->name, $code);
    }
}
