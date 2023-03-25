<?php

    function mos_redirect_if_logged_in() {
        if ( is_user_logged_in() && is_page( 'autentificare' ) || ( is_user_logged_in() && is_page( 'inregistrare' ) ) ) {
            wp_redirect( home_url() );
            exit();
        }
    }
