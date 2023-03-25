<?php

    function mos_hide_admin_bar() {
        $currentUser = wp_get_current_user();
        if ( count( $currentUser->roles ) === 1 and $currentUser->roles[0] === 'client' ) {
            show_admin_bar( false );
        }
    }
