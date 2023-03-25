<?php

function woo_init()
{
  if (defined('WC_ABSPATH')) {
    // WC 3.6+ - Cart and other frontend functions are not included for REST requests.
    include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
    include_once WC_ABSPATH . 'includes/wc-notice-functions.php';
    include_once WC_ABSPATH . 'includes/wc-template-hooks.php';
  }

  if (
    null === WC()->session
  ) {
    $session_class = apply_filters('woocommerce_session_handler', 'WC_Session_Handler');

    WC()->session = new $session_class();
    WC()->session->init();
  }

  if (
    null === WC()->customer
  ) {
    WC()->customer = new WC_Customer(get_current_user_id(), true);
  }

  if (
    null === WC()->cart
  ) {
    WC()->cart = new WC_Cart();

    // We need to force a refresh of the cart contents from session here (cart contents are normally refreshed on wp_loaded, which has already happened by this point).
    WC()->cart->get_cart();
  }

  return true;
}
