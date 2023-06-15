<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit; }

class Wp_Smart_Plugin_Manager_Admin_Options extends Wp_Smart_Plugin_Manager_Init {

  /**
   * Wp_Smart_Plugin_Manager_Admin constructor.
   *
   * @since 1.0.0
   * @access public
   */
  public function __construct() {
    parent::__construct();

    add_action( 'admin_menu', array( $this, 'wp_smart_plugin_manager_admin_menu' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'wp_smart_plugin_manager_admin_scripts' ) );
    add_action( 'admin_head', array( $this, 'badge_pro_wp_smart_plugin_manager' ) );
  }

  /**
   * Function for create submenu in settings
   * 
   * @since 1.0.0
   * @access public
   * @return array
   */
  public function wp_smart_plugin_manager_admin_menu() {
    add_submenu_page(
      'options-general.php', // parent page slug
      esc_html__( 'Gerenciador de Plugins Inteligente - Lite', 'wp-smart-plugin-manager'), // page title
      esc_html__( 'Gerenciador de Plugins Inteligente', 'wp-smart-plugin-manager'), // submenu title
      'manage_options', // user capabilities
      'wp-smart-plugin-manager-lite', // page slug
      array( $this, 'wp_smart_plugin_manager_settings_page' ) // public function for print content page
    );
  }


  /**
   * Plugin general setting page and save options
   * 
   * @since 1.0.0
   * @access public
   */
  public function wp_smart_plugin_manager_settings_page() {
    $settingSaves = false;
    $settings_array = array();

    // Save global options
    if( current_user_can( 'manage_options' ) && isset( $_POST[ 'save_settings' ] ) ) {
      update_option( 'wp-smart-plugin-manager-setting', $_POST );
      $this->wp_smart_plugin_manager_settings = $_POST;

      $settingSaves = true;
    }

    $options = get_option( 'wp-smart-plugin-manager-setting' );

    include_once WP_SMART_PLUGIN_MANAGER_DIR . 'includes/admin/settings.php';
  }


  /**
   * Enqueue admin scripts in page settings only
   * 
   * @since 1.0.0
   * @access public
   * @return void
   */
  public function wp_smart_plugin_manager_admin_scripts() {
    $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $version = Wp_Smart_Plugin_Manager()->version;
    
    if ( false !== strpos( $url, 'options-general.php?page=wp-smart-plugin-manager-lite' ) ) {
      wp_enqueue_script( 'wp-smart-plugin-manager-admin-scripts', WP_SMART_PLUGIN_MANAGER_URL . 'assets/js/wp-smart-plugin-manager-admin-scripts.js', array('jquery'), $version );
      wp_enqueue_style( 'wp-smart-plugin-manager-admin-styles', WP_SMART_PLUGIN_MANAGER_URL . 'assets/css/wp-smart-plugin-manager-admin-styles.css', array(), $version );
    }
  }


  /**
   * Display badge in CSS for get pro in plugins page
   * 
   * @since 2.0.0
   * @access public
   */
  public function badge_pro_wp_smart_plugin_manager() {
    echo '<style>
      #get-pro-wp-smart-plugin-manager {
        display: inline-block;
        padding: 0.35em 0.6em;
        font-size: 0.8125em;
        font-weight: 600;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        background-color: #008aff;
        transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out;
      }
      #get-pro-wp-smart-plugin-manager:hover {
        background-color: #0078ed;
      }
    </style>';
  }

}

new Wp_Smart_Plugin_Manager_Admin_Options();