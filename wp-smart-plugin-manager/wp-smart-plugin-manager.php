<?php

/**
 * Plugin Name: 			Gerenciador de Plugins Inteligente - Lite
 * Description: 			Extensão que permite controlar o carregamento de plugins por páginas, posts ou URLs.
 * Plugin URI: 				https://meumouse.com/plugins/gerenciador-de-plugins-inteligente-wordpress/
 * Author: 					MeuMouse.com
 * Author URI: 				https://meumouse.com/
 * Version: 				1.0.0
 * Requires PHP: 			7.2
 * Tested up to:      		6.2.2
 * Text Domain: 			wp-smart-plugin-manager
 * Domain Path: 			/languages
 * License: 				GPL2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// Define WP_SMART_PLUGIN_MANAGER_PLUGIN_FILE.
if ( ! defined( 'WP_SMART_PLUGIN_MANAGER_PLUGIN_FILE' ) ) {
	define( 'WP_SMART_PLUGIN_MANAGER_PLUGIN_FILE', __FILE__ );
}

if ( ! class_exists( 'Wp_Smart_Plugin_Manager' ) ) {
  
/**
 * Main Wp_Smart_Plugin_Manager Class
 *
 * @class Wp_Smart_Plugin_Manager
 * @version 1.0.0
 * @since 1.0.0
 * @package MeuMouse.com
 */
final class Wp_Smart_Plugin_Manager {

		/**
		 * Wp_Smart_Plugin_Manager The single instance of Wp_Smart_Plugin_Manager.
		 *
		 * @var object
		 * @since 1.0.0
		 */
		private static $instance = null;

		/**
		 * The token
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $token;

		/**
		 * The version number
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version;

		/**
		 * Constructor function.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function __construct() {
			$this->token = 'wp-smart-plugin-manager';
			$this->version = '1.0.0';
			
			add_action( 'plugins_loaded', array( $this, 'wp_smart_plugin_manager_load_checker' ), 5 );
		}
		
		public function wp_smart_plugin_manager_load_checker() {
			if ( !function_exists( 'is_plugin_active' ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			// Display notice if PHP version is bottom 7.2
			if ( version_compare( phpversion(), '7.2', '<' ) ) {
				add_action( 'admin_notices', array( $this, 'wp_smart_plugin_manager_php_version_notice' ) );
				return;
			}

			add_action( 'init', array( $this, 'load_plugin_textdomain' ), -1 );
			add_action( 'plugins_loaded', array( $this, 'setup_constants' ), 15 );
			add_action( 'plugins_loaded', array( $this, 'setup_includes' ), 20 );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'wp_smart_plugin_manager_plugin_links' ), 10, 4 );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'get_pro_wp_smart_plugin_manager_link' ), 10, 4 );
		}

		/**
		 * Main Wp_Smart_Plugin_Manager Instance
		 *
		 * Ensures only one instance of Wp_Smart_Plugin_Manager is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 * @see Wp_Smart_Plugin_Manager()
		 * @return Main Wp_Smart_Plugin_Manager instance
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Setup plugin constants
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function setup_constants() {

			// Plugin Folder Path.
			if ( ! defined( 'WP_SMART_PLUGIN_MANAGER_DIR' ) ) {
				define( 'WP_SMART_PLUGIN_MANAGER_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL.
			if ( ! defined( 'WP_SMART_PLUGIN_MANAGER_URL' ) ) {
				define( 'WP_SMART_PLUGIN_MANAGER_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File.
			if ( ! defined( 'WP_SMART_PLUGIN_MANAGER_FILE' ) ) {
				define( 'WP_SMART_PLUGIN_MANAGER_FILE', __FILE__ );
			}

			$this->define( 'WP_SMART_PLUGIN_MANAGER_ABSPATH', dirname( WP_SMART_PLUGIN_MANAGER_FILE ) . '/' );
			$this->define( 'WP_SMART_PLUGIN_MANAGER_VERSION', $this->version );
		}


		/**
		 * Define constant if not already set.
		 *
		 * @param string $name  Constant name.
		 * @param string|bool $value Constant value.
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}


		/**
		 * What type of request is this?
		 *
		 * @param  string $type admin, ajax, cron or wciend.
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin':
					return is_admin();
				case 'ajax':
					return defined( 'DOING_AJAX' );
				case 'cron':
					return defined( 'DOING_CRON' );
			}
		}


		/**
		 * Include required files
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function setup_includes() {

			/**
			 * Class init plugin
			 * 
			 * @since 1.0.0
			 */
			include_once WP_SMART_PLUGIN_MANAGER_DIR . 'includes/class-wp-smart-plugin-manager-init.php';

			/**
			 * Core functions
			 * 
			 * @since 1.0.0
			 */
			include_once WP_SMART_PLUGIN_MANAGER_DIR . 'includes/wp-smart-plugin-manager-functions.php';

			/**
			 * Admin options
			 * 
			 * @since 1.0.0
			 */
			include_once WP_SMART_PLUGIN_MANAGER_DIR . 'includes/admin/class-wp-smart-plugin-manager-admin-options.php';
		}

		/**
		 * PHP version notice
		 */
		public function wp_smart_plugin_manager_php_version_notice() {
			echo '<div class="notice is-dismissible error">
					<p>' . __( '<strong>Gerenciador de Plugins Inteligente - Lite</strong> requer a versão do PHP 7.2 ou maior. Contate o suporte da sua hospedagem para realizar a atualização.', 'wp-smart-plugin-manager' ) . '</p>
				</div>';
		}

		/**
		 * Plugin action links
		 * 
		 * @since 1.0.0
		 * @return array
		 */
		public function wp_smart_plugin_manager_plugin_links( $action_links ) {
			$plugins_links = array(
				'<a href="' . admin_url( 'options-general.php?page=wp-smart-plugin-manager-lite' ) . '">'. __( 'Configurar', 'wp-smart-plugin-manager' ) .'</a>',
				'<a href="https://meumouse.com/docs/plugins/gerenciador-de-plugins-inteligente-wordpress/" target="_blank">'. __( 'Ajuda', 'wp-smart-plugin-manager' ) .'</a>'
			);

			return array_merge( $plugins_links, $action_links );
		}


		/**
		 * Plugin action links Pro version
		 * 
		 * @since 1.0.0
		 * @return array
		 */
		public static function get_pro_wp_smart_plugin_manager_link( $action_links ) {
			$plugins_links = array(
			'<a id="get-pro-wp-smart-plugin-manager" target="_blank" href="https://meumouse.com/plugins/gerenciador-de-plugins-inteligente-wordpress/?utm_source=wordpress&utm_medium=plugins-list&utm_campaign=spmwp">' . __( 'Seja PRO', 'wp-smart-plugin-manager' ) . '</a>'
			);
		
			return array_merge( $plugins_links, $action_links );
		}


		/**
		 * Load the plugin text domain for translation.
		 */
		public static function load_plugin_textdomain() {
			load_plugin_textdomain( 'wp-smart-plugin-manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', WP_SMART_PLUGIN_MANAGER_PLUGIN_FILE ) );
		}

		/**
		 * Cloning is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Trapaceando?', 'wp-smart-plugin-manager' ), '1.0.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Trapaceando?', 'wp-smart-plugin-manager' ), '1.0.0' );
		}

	}
}

/**
 * Returns the main instance of Wp_Smart_Plugin_Manager to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Wp_Smart_Plugin_Manager
 */
function Wp_Smart_Plugin_Manager() { //phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return Wp_Smart_Plugin_Manager::instance();
}

/**
 * Initialise the plugin
 */
Wp_Smart_Plugin_Manager();