<?php
/**
 * ThemeForest-Check
 *
 * @package   ThemeForest_Check
 * @author    Japh <japh@envato.com>
 * @license   GPL-2.0+
 * @link      http://themeforest.net
 * @copyright 2013 Japh
 */

/**
 * ThemeForest-Check class
 *
 * @package ThemeForest_Check
 * @author  Japh <japh@envato.com>
 */
class ThemeForest_Check {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.4';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'themeforest-check';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		add_action( 'themecheck_checks_loaded', array( $this, 'disable_checks' ) );
		add_action( 'themecheck_checks_loaded', array( $this, 'add_checks' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Disable Theme-Check checks that aren't relevant for ThemeForest themes
	 *
	 * @since    1.0.0
	 */
	function disable_checks() {
		global $themechecks;

		$checks_to_disable = array(
			'IncludeCheck',
			'I18NCheck',
			'AdminMenu',
			'Bad_Checks',
			'MalwareCheck',
			'Theme_Support',
			'CustomCheck',
			'EditorStyleCheck',
			'IframeCheck',
		);

		foreach ( $themechecks as $keyindex => $check ) {
			if ( $check instanceof themecheck ) {
				$check_class = get_class( $check );
				if ( in_array( $check_class, $checks_to_disable ) ) {
					unset( $themechecks[$keyindex] );
				}
			}
		}
	}

	/**
	 * Disable Theme-Check checks that aren't relevant for ThemeForest themes
	 *
	 * @since    1.0.0
	 */
	function add_checks() {
		global $themechecks;

		// load all the checks in the checks directory
		$dir = 'checks';
		foreach ( glob( dirname( __FILE__ ) . '/' .$dir . '/*.php' ) as $file ) {

			include ( $file );

		}
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.1
	 */
	public function enqueue_admin_styles() {

		$screen = get_current_screen();
		if ( 'appearance_page_themecheck' == $screen->id ) {

			if ( ! isset( $_POST[ 'themename' ] ) ) {
				wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
			}

		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.1
	 */
	public function enqueue_admin_scripts() {

		$screen = get_current_screen();
		if ( 'appearance_page_themecheck' == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );

			if ( ! isset( $_POST[ 'themename' ] ) ) {

				$intro = '';
				$intro .= '<h2><img src="' . plugins_url( 'img/themeforest-logo-mini.png', __FILE__ ) . '" /> ThemeForest-Check</h2>';
				$intro .= '<p>A supplement to the Theme-Check plugin that adds checks for ThemeForest\'s WordPress Theme Submission Requirements, and removes checks that aren\'t required.</p>';

				$tfc_intro['text'] = $intro;

				wp_localize_script( $this->plugin_slug . '-admin-script', 'tfc_intro', $tfc_intro );

			}
		}

	}

}
