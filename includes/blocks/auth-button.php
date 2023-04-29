<?php

    function mos_auth_button() {
        $user           = wp_get_current_user();
        $user_logged_in = $user->exists();
        $name           = $user_logged_in ? $user->user_login : __( 'Sign in', 'mos' );
        // Get the current language
        $current_language = pll_current_language();

        ob_start();
        ?>

        <div class="wp-block-mos-auth-button has-dropdown">

            <?php
                if ( ! $user_logged_in ) {
                    if ( $current_language == 'ro' ) {
                        ?>
                        <a class="mos-block-auth-button" href="<?php echo esc_url( site_url( '/autentificare' ) ) ?>">
                            <?php echo $name; ?>
                        </a>
                        <?php
                    } else if ( $current_language == 'en' ) {
                        ?>
                        <a class="mos-block-auth-button" href="<?php echo esc_url( site_url( '/en/login' ) ) ?>">
                            <?php echo $name; ?>
                        </a>
                        <?php
                    } else if ( $current_language == 'hu' ) {
                        ?>
                        <a class="mos-block-auth-button" href="<?php echo esc_url( site_url( '/hu/belepes' ) ) ?>">
                            <?php echo $name; ?>
                        </a>
                        <?php
                    }
                    ?>

                    <?php
                }
            ?>

            <?php
                if ( $user_logged_in ) {
                    ?>
                    <a class="mos-block-auth-button" href="#">
                        <?php echo $name; ?>
                    </a>
                    <?php
                    if ( $current_language == 'ro' ) {
                        ?>
                        <div class="dropdown">
                            <div class="dropdown-wrapper">
                                <a href='<?php echo esc_url( site_url( '/comanda-noua' ) ) ?>'
                                   class="dropdown-item"><?php echo 'Comandă Nouă' ?></a>
                                <a href='<?php echo esc_url( site_url( '/contul-meu/' ) ) ?>'
                                   class="dropdown-item"><?php echo 'Contul Meu' ?></a>
                                <a href='<?php echo wp_logout_url( home_url() ) ?>'
                                   class="dropdown-item"><?php echo 'Deconectare' ?></a>
                            </div>
                        </div>
                        <?php
                    } else if ( $current_language == 'en' ) {
                        ?>
                        <div class="dropdown">
                            <div class="dropdown-wrapper">
                                <a href='<?php echo esc_url( site_url( '/en/new-online-order/' ) ) ?>'
                                   class="dropdown-item"><?php echo 'New Online Order' ?></a>
                                <a href='<?php echo esc_url( site_url( '/en/my-account/' ) ) ?>'
                                   class="dropdown-item"><?php echo 'My Account' ?></a>
                                <a href='<?php echo wp_logout_url( home_url() ) ?>'
                                   class="dropdown-item"><?php echo 'Logout' ?></a>
                            </div>
                        </div>
                        <?php
                    } else if ( $current_language == 'hu' ) {
                        ?>
                        <div class="dropdown">
                            <div class="dropdown-wrapper">
                                <a href='<?php echo esc_url( site_url( '/hu/uj-online-rendeles/' ) ) ?>'
                                   class="dropdown-item"><?php echo 'Új Online Rendelés' ?></a>
                                <a href='<?php echo esc_url( site_url( '/hu/a-fiokom/' ) ) ?>'
                                   class="dropdown-item"><?php echo 'A Fiókom' ?></a>
                                <a href='<?php echo wp_logout_url( home_url() ) ?>'
                                   class="dropdown-item"><?php echo 'Kijelentkezés' ?></a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                }
            ?>

        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

