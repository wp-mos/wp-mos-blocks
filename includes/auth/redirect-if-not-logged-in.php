<?php

    function mos_redirect_if_not_logged_in() {
        if ( ! is_user_logged_in() && is_page( 'contul-meu' ) || ( ! is_user_logged_in() && is_page( 'comanda-noua' ) ) ) {
            wp_redirect( home_url() );
            exit();
        }
    }
