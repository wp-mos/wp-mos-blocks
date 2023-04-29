<?php

    function mos_redirect_if_not_logged_in() {
        if ( ! is_user_logged_in() && is_page( 'contul-meu' ) || ( ! is_user_logged_in() && is_page( 'comanda-noua' ) ) ) {
            wp_redirect( home_url() . '/autentificare/' );
            exit();
        }
    }

    function mos_redirect_if_not_logged_in_en() {
        if ( ! is_user_logged_in() && is_page( 'my-account' ) || ( ! is_user_logged_in() && is_page( 'new-online-order' ) ) ) {
            wp_redirect( home_url() . '/en/login/' );
            exit();
        }
    }

    function mos_redirect_if_not_logged_in_hu() {
        if ( ! is_user_logged_in() && is_page( 'uj-online-rendeles' ) || ( ! is_user_logged_in() && is_page( 'a-fiokom' ) ) ) {
            wp_redirect( home_url() . '/hu/belepes/' );
            exit();
        }
    }
