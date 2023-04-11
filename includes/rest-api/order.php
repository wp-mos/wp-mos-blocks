<?php

    function mos_rest_api_order( $request ) {
        woo_init();

        $response = [ 'status' => 2 ];
        $user     = wp_get_current_user();
        $params   = $request->get_params();
        $files    = $request->get_file_params();

        $current_language = pll_current_language();

        if ( ! is_user_logged_in() ) {
            $response['status'] = 1;

            return rest_ensure_response( $response );
        }

        // Save files in wp-content/uploads/orders directory
        $upload_dir = wp_upload_dir()['basedir'] . '/orders/';
        if ( ! file_exists( $upload_dir ) ) {
            mkdir( $upload_dir, 0755, true );
        }

        $product_map = array();
        $product_ids = array();

        WC()->cart->empty_cart();

        foreach ( $files as $key => $file ) {
            $filename = $file['name'];
            $tmp_name = $file['tmp_name'];
            $path     = $upload_dir . $filename;
            move_uploaded_file( $tmp_name, $path );

            $index = intval( str_replace( "file-", "", $key ) );

            $price    = $params[ 'price-' . $index ];
            $quantity = $params[ 'quantity-' . $index ];
            $material = $params[ 'material-' . $index ];

            $response['key']      = $index;
            $response['quantity'] = $quantity;

            $new_sku = generate_sku();

            $product_id = wp_insert_post( array(
                'post_type'    => 'product',
                'post_title'   => $filename,
                'post_content' => 'Material: ' . $material,
                'post_status'  => 'publish',
                'meta_input'   => array(
                    '_price'         => $price,
                    '_stock_status'  => 'instock',
                    '_stock'         => $quantity,
                    '_sku'           => $new_sku,
                    '_regular_price' => $price,
                    '_visibility'    => 'visible',
                ),
            ) );

            // Add download link as meta field
            update_post_meta( $product_id, 'download_link', $path );

            // Add product to map
            $product_map[ 'product-' . $key ] = array(
                'file'     => $path,
                'price'    => $price,
                'quantity' => $quantity
            );

            // Add product to cart
            WC()->cart->add_to_cart( $product_id, $quantity );
            $product_ids[] = $product_id;
        }

        $response['message'] = 'Products created successfully';

        // Generate cart URL
        $cart_url = wc_get_cart_url();
        $cart     = WC()->cart->get_cart();

        $checkout_url = '';
        // Generate checkout URL
        if ( $current_language == 'ro' ) {
            $checkout_url = wc_get_checkout_url();
        } else if ( $current_language == 'en' ) {
            $checkout_url = home_url() . '/en/checkout/';
        } else if ( $current_language == 'hu' ) {
            $checkout_url = home_url() . '/hu/penztar/';
        }

        $response['cart_url']     = $cart_url;
        $response['checkout_url'] = $checkout_url;
        $response['cart']         = $cart;
        $response['product_map']  = $product_map;
        $response['user']         = $user->data->ID;
        $response['params']       = $params;
        $response['files']        = $files;

        return rest_ensure_response( $response );
    }
