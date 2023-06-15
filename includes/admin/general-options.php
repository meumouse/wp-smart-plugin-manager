<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit; } ?>


<div class="wp-smart-plugin-manager-general-options mt-5">
  <table class="form-table">
     <tr>
        <th>
           <?php echo esc_html__( 'Desativar atualização de valores na finalização de compra', 'wp-smart-plugin-manager' ) ?>
           <span class="wp-smart-plugin-manager-description"><?php echo esc_html__('Ative esta opção para evitar a atualização de valores na finalização de compra, ou se estiver com carregamento infinito na finalização da compra.', 'wp-smart-plugin-manager' ) ?></span>
        </th>
        <td>
           <div class="form-check form-switch">
              <input type="checkbox" class="toggle-switch" id="disable_update_checkout" name="disable_update_checkout" value="yes" <?php checked( isset( $options['disable_update_checkout'] ) == 'yes' ); ?> />
           </div>
        </td>
      </tr>
  </table>
</div>