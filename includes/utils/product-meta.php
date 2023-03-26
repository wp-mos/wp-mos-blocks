<?php
// Add custom meta box to product edit screen
function add_product_download_link_meta_box()
{
  add_meta_box(
    'product_download_link_meta_box',
    'Download Link',
    'render_product_download_link_meta_box',
    'product',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'add_product_download_link_meta_box');

// Render custom meta box
function render_product_download_link_meta_box($post)
{
  $download_link = get_post_meta($post->ID, 'download_link', true);
  echo '<input type="text" readonly value="' . $download_link . '" style="width:100%;padding:10px;margin-bottom:20px;">';
}
