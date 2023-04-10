<?php

    function mos_redirect_if_logged_in() {
        if (
            is_user_logged_in() && is_page( 'autentificare' ) ||
            ( is_user_logged_in() && is_page( 'creeaza-cont-nou' ) ) ||
            ( is_user_logged_in() && is_page( 'login' ) ) ||
            ( is_user_logged_in() && is_page( 'new-account' ) ) ||
            ( is_user_logged_in() && is_page( 'belepes' ) ) ||
            ( is_user_logged_in() && is_page( 'uj-felhasznalo-letrehozasa' ) )
        ) {
            wp_redirect( home_url() );
            exit();
        }
    }
