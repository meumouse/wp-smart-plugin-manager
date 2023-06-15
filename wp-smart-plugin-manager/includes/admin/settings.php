<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; } ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

<div class="d-flex">
    <h1 class="wp-smart-plugin-manager-admin-section-tile"><?php echo get_admin_page_title() ?></h1>
</div>

<div class="wp-smart-plugin-manager-admin-title-description">
    <p><?php echo esc_html__( 'Configure abaixo o parcelamento e descontos de produtos. Se precisar de ajuda para configurar, acesse nossa', 'wp-smart-plugin-manager' ) ?>
        <a class="fancy-link" href="https://meumouse.com/docs/plugins/parcelas-customizadas-para-woocommerce/" target="_blank"><?php echo esc_html__( 'Central de ajuda', 'wp-smart-plugin-manager' ) ?></a>
    </p>
</div>

<?php

    if( $settingSaves === true) { ?>
        <div class="toast update-notice-spm-wp">
            <div class="toast-header bg-success text-white">
                <i class="fa-regular fa-circle-check me-3"></i>
                <span class="me-auto"><?php _e( 'Salvo com sucesso', 'wp-smart-plugin-manager' ); ?></span>
                <button class="btn-close btn-close-white ms-2 hide-toast" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"><?php _e( 'As configurações foram atualizadas!', 'wp-smart-plugin-manager' ); ?></div>
        </div>
        <?php
    }

    settings_errors(); ?>

<div class="wp-smart-plugin-manager-wrapper">
    <form method="post" action="" class="wp-smart-plugin-manager-form" name="wp-smart-plugin-manager">
        <input type="hidden" name="wp-smart-plugin-manager" value="1"/>
        <?php
        include_once WP_SMART_PLUGIN_MANAGER_DIR . 'includes/admin/general-options.php';
        ?>
        <button id="save_settings" name="save_settings" class="btn btn-primary m-5 button-loading" type="submit">
            <span class="span-inside-button-loader"><?php esc_attr_e( 'Salvar alterações', 'wp-smart-plugin-manager' ); ?></span>
        </button>
    </form>
</div>