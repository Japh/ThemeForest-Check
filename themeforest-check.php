<?php
/**
 * ThemeForest-Check
 *
 * A supplement to the Theme-Check plugin that adds checks for ThemeForest's
 * WordPress Theme Submission Requirements, and removes checks that aren't
 * required.
 *
 * @package   ThemeForest_Check
 * @author    Japh <japh@envato.com>
 * @license   GPL-2.0+
 * @link      http://themeforest.net
 * @copyright 2013 Japh
 *
 * @wordpress-plugin
 * Plugin Name: ThemeForest-Check
 * Plugin URI:  http://themeforest.net
 * Description: A supplement to the Theme-Check plugin that adds checks for ThemeForest's WordPress Theme Submission Requirements, and removes checks that aren't required.
 * Version:     1.0.4
 * Author:      Japh
 * Author URI:  http://themeforest.net/user/Japh
 * Text Domain: themeforest-check-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

require_once( plugin_dir_path( __FILE__ ) . 'class-themeforest-check.php' );

ThemeForest_Check::get_instance();
