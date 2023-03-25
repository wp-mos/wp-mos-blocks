<?php

    function mos_redirect_clients_to_frontend() {
        $currentUser = wp_get_current_user();
        if ( count( $currentUser->roles ) === 1 and $currentUser->roles[0] === 'client' ) {
            wp_redirect( home_url() );
            exit();
        }
    }
