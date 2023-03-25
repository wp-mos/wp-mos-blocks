<?php

    function mos_enqueue_scripts(): void {
        $authURLs = json_encode( [
            'root'  => esc_url_raw( rest_url( 'mos/v1/order' ) ),
            'nonce' => wp_create_nonce( 'wp_rest' )
        ] );

        wp_add_inline_script(
            'mos-blocks-order-form-script',
            "const settings = {$authURLs};",
            'before'
        );
    }
