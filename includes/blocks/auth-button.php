<?php

    function mos_auth_button() {
        $user           = wp_get_current_user();
        $user_logged_in = $user->exists();
        $name           = $user_logged_in ? $user->user_login : __( 'Sign in', 'mos' );

        ob_start();
        ?>

        <div class="wp-block-mos-auth-button has-dropdown">

            <?php
                if ( ! $user_logged_in ) {
                    ?>
                    <a class="mos-block-auth-button" href="<?php echo esc_url( site_url( '/autentificare' ) ) ?>">
                        <?php echo $name; ?>
                    </a>
                    <?php
                }
            ?>

            <?php
                if ( $user_logged_in ) {
                    ?>
                    <a class="mos-block-auth-button" href="#">
                        <?php echo $name; ?>
                    </a>
                    <div class="dropdown">
                        <div class="dropdown-wrapper">
                            <a href='<?php echo esc_url( site_url( '/contul-meu' ) ) ?>'
                               class="dropdown-item"><?php _e( 'My Account', 'mos' ) ?></a>
                            <a href='<?php echo esc_url( site_url( '/comanda-noua' ) ) ?>'
                               class="dropdown-item"><?php _e( 'New Order', 'mos' ) ?></a>
                            <a href='<?php echo wp_logout_url( home_url() ) ?>'
                               class="dropdown-item"><?php _e( 'Logout', 'mos' ) ?></a>
                        </div>
                    </div>
                    <?php
                }
            ?>

        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

