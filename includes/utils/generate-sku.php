<?php
function generate_sku()
{
  $timestamp = microtime(true) * 1000;
  $random_string = wp_generate_password(6, false);
  return 'SKU-' . $timestamp . '-' . $random_string;
}
