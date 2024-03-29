<?php

    function mos_login_form() {
        if ( is_user_logged_in() ) {
            return '';
        }

        $output     = '';
        $login_data = array();

        // Get the current language
        $current_language = pll_current_language();

        if ( isset( $_POST['login-form-email'] ) && isset( $_POST['login-form-password'] ) ) {
            $email    = sanitize_email( $_POST['login-form-email'] );
            $password = sanitize_text_field( $_POST['login-form-password'] );

            if ( empty( $email ) || empty( $password ) ) {
                $output .= '<div class="login-error">' . esc_html__( 'Invalid user and password.', 'mos' ) . '</div>';
            }

            if ( empty( $output ) ) {
                $login_data['user_login']    = $email;
                $login_data['user_password'] = $password;
                $login_data['remember']      = true;

                $user = wp_signon( $login_data, false );
                if ( is_wp_error( $user ) ) {
                    $output .= '<div class="login-error">' . esc_html__( 'Invalid user and password.', 'mos' ) . '</div>';
                } else {
                    // Generate and store a token for the user
                    $token = wp_generate_password( 32 );
                    update_user_meta( $user->ID, 'auth_token', $token );

                    // Set the token as a cookie
                    setcookie( 'auth_token', $token, time() + ( 86400 * 30 ), "/" ); // Cookie will expire in 30 days
                    wp_set_auth_cookie( $user->ID );

                    if ( $current_language == 'ro' ) {
                        wp_safe_redirect( home_url() . '/comanda-noua/' );
                    } else if ( $current_language == 'en' ) {
                        wp_safe_redirect( home_url() . '/en/new-order/' );
                    } else if ( $current_language == 'hu' ) {
                        wp_safe_redirect( home_url() . '/hu/uj-online-rendeles/' );
                    }

                    exit;
                }
            }
        }


        ob_start(); ?>

        <div class="wp-block-mos-login-form">
            <!-- sof: login form -->
            <form id="login-form" class="login-form" method="post">

                <div class="form-group">
                    <label for="login-form-email"><?php esc_html_e( 'Email', 'mos' ); ?></label>
                    <input type="text" id="login-form-email" name="login-form-email" class="form-input"
                           placeholder="<?php esc_attr_e( 'Email', 'mos' ); ?>"
                           value="<?php echo isset( $_POST['login-form-email'] ) ? esc_attr( $_POST['login-form-email'] ) : ''; ?>"/>
                </div>

                <div class="form-group">
                    <label for="login-form-password"><?php esc_html_e( 'Password', 'mos' ); ?></label>
                    <input type="password" id="login-form-password" name="login-form-password" class="form-input"
                           placeholder="<?php esc_attr_e( 'Password', 'mos' ); ?>"/>
                </div>

                <div id="login-status" class="login-status" style="margin-bottom: 2rem;"><?php echo $output; ?></div>

                <div class="form-footer">
                    <div class="form-footer-meta">
                        <?php esc_html_e( 'Don\'t have an account yet?', 'mos' ); ?>
                        <?php
                            $register_url = '';
                            if ( $current_language == 'ro' ) {
                                $register_url = site_url() . '/creeaza-cont-nou/';
                            } else if ( $current_language == 'en' ) {
                                $register_url = site_url() . '/en/new-account/';
                            } else if ( $current_language == 'hu' ) {
                                $register_url = site_url() . '/hu/uj-felhasznalo-letrehozasa/';
                            }
                        ?>
                        <a class="animated-link"
                           href="<?php echo $register_url; ?>"><?php esc_html_e( 'Register', 'mos' ); ?></a>
                    </div>
                    <button class="form-subscribe-button"
                            type="submit"><?php esc_html_e( 'Log in to your account', 'mos' ); ?></button>
                </div>

            </form>
            <!-- eof: login form -->
        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
