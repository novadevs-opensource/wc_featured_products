<?php

register_activation_hook(__FILE__, 'qs_fp_plugin_activate');

function qs_fp_plugin_activate()
{
    if (!is_woocommerce_activated()) {
        $message = '¡Necesitas instalar y habilitar WooCommerce!';
    }

    $message = 'El plugin se ha instalado satisfactoriamente';

    return $message;
}
