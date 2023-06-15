<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

/**
 * Main class autoloader
 * 
 * @package MeuMouse.com
 * @version 1.0.0
 */
class Wp_Smart_Plugin_Manager_Init {

	public $wp_smart_plugin_manager_settings = array();
  public $options = array();
  
  public function __construct() {
    // load plugin setting
    if( empty( $this->wp_smart_plugin_manager_settings ) ) {
      $this->wp_smart_plugin_manager_settings = get_option( 'woo-custom-installments-setting' );
    }
  }


  /**
	 * Plugin default settings
   * 
	 * @return array
	 * @since 1.0.0
	 * @access public
	 */
	public $default_settings = array(
    'fee_installments_global' => '2.0',
    'max_qtd_installments' => '12',
    'max_qtd_installments_without_fee' => '3',
    'min_value_installments' => '20',
    'display_discount_price_hook' => 'display_loop_and_single_product',
    'get_type_best_installments' => 'best_installment_without_fee',
    'hook_display_best_installments' => 'display_loop_and_single_product',
    'hook_display_best_installments_after_before_discount' => 'after_discount'
  );


  /**
	 * Function for get plugin general settings
	 * 
	 * @return string 
	 * @since 1.0.0
	 * @access public
	 */
	public function getSetting( $key ) {
    if( ! empty( $this->wp_smart_plugin_manager_settings) && isset( $this->wp_smart_plugin_manager_settings[ $key ] ) ) {
      return $this->wp_smart_plugin_manager_settings[ $key ];
    }

    if( isset( $this->default_settings[ $key ] ) ) {
      return $this->default_settings[ $key ];
    }

    return false;
  }

}

new Wp_Smart_Plugin_Manager_Init();