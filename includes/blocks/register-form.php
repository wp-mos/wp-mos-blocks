<?php
    function mos_register_form() {
        if ( is_user_logged_in() ) {
            return '';
        }

        // Perform validation on form data
        $errors = array();

        // Process form submission
        if ( isset( $_POST['register-form-submit'] ) ) {
            $name             = sanitize_text_field( $_POST['register-form-name'] );
            $surname          = sanitize_text_field( $_POST['register-form-surname'] );
            $email            = sanitize_email( $_POST['register-form-email'] );
            $password         = sanitize_text_field( $_POST['register-form-password'] );
            $confirm_password = sanitize_text_field( $_POST['register-form-confirm-password'] );


            if ( empty( $name ) ) {
                $errors[] = __( 'First Name is required', 'mos' );
            }

            if ( empty( $surname ) ) {
                $errors[] = __( 'Last Name is required', 'mos' );
            }

            if ( empty( $email ) ) {
                $errors[] = __( 'Email is required', 'mos' );
            } elseif ( ! is_email( $email ) ) {
                $errors[] = __( 'Email is invalid', 'mos' );
            } elseif ( email_exists( $email ) ) {
                $errors[] = __( 'This email is already registered', 'mos' );
            }

            if ( empty( $password ) ) {
                $errors[] = __( 'Password is required', 'mos' );
            } elseif ( $password != $confirm_password ) {
                $errors[] = __( 'Passwords do tot match', 'mos' );
            }

            // If there are errors, display them
            if ( empty( $errors ) ) {
                // Create new user
                $user_id = wp_create_user( $email, $password, $email );

                if ( is_wp_error( $user_id ) ) {
                    echo '<div class="error">' . $user_id->get_error_message() . '</div>';
                } else {
                    // Set user meta data
                    update_user_meta( $user_id, 'first_name', $name );
                    update_user_meta( $user_id, 'last_name', $surname );

                    // Log user in
                    wp_set_auth_cookie( $user_id, true );
                    wp_redirect( home_url() );
                    exit;
                }
            }
        }

        // Display registration form
        ob_start(); ?>

        <div class="wp-block-mos-register-form">
            <!-- sof: register form -->
            <form id="register-form" class="register-form" method="post">

                <div class="form-group">
                    <label><?php esc_html_e( 'First Name', 'mos' ); ?></label>
                    <input type="text" id="register-form-name" name="register-form-name" class="form-input"
                           placeholder="<?php esc_attr_e( 'First Name', 'mos' ) ?>"/>
                    <div id="login-status" class="login-status">
                        <?php
                            if ( isset( $_POST['register-form-submit'] ) ) {
                                if ( empty( $_POST['register-form-name'] ) ) {
                                    echo '<div class="error">First Name is required</div>';
                                }
                            }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php esc_html_e( 'Last Name', 'mos' ); ?></label>
                    <input type="text" id="register-form-surname" name="register-form-surname" class="form-input"
                           placeholder="<?php esc_attr_e( 'Last Name', 'mos' ) ?>"/>
                    <div id="login-status" class="login-status">
                        <?php
                            if ( isset( $_POST['register-form-submit'] ) ) {
                                if ( empty( $_POST['register-form-surname'] ) ) {
                                    echo '<div class="error">Last Name is required</div>';
                                }
                            }
                        ?>
                    </div>
                </div>


                <div class="form-group">
                    <label><?php esc_html_e( 'Email', 'mos' ); ?></label>
                    <input type="email" id="register-form-email" name="register-form-email" class="form-input"
                           placeholder="<?php esc_attr_e( 'Email', 'mos' ); ?>"/>
                    <div id="login-status" class="login-status">
                        <?php
                            if ( isset( $_POST['register-form-submit'] ) ) {
                                if ( empty( $_POST['register-form-email'] ) ) {
                                    echo '<div class="error">Email is required</div>';
                                } elseif ( ! is_email( $_POST['register-form-email'] ) ) {
                                    echo '<div class="error">Email is invalid</div>';
                                } elseif ( email_exists( $_POST['register-form-email'] ) ) {
                                    echo '<div class="error">This email is already registered</div>';
                                }
                            }
                        ?>
                    </div>
                </div>


                <div class="form-group">
                    <label><?php esc_html_e( 'Password', 'mos' ); ?></label>
                    <input type="password" id="register-form-password" name="register-form-password" class="form-input"
                           placeholder="<?php esc_attr_e( 'Password', 'mos' ); ?>"/>
                    <div id="login-status" class="login-status">
                        <?php
                            if ( isset( $_POST['register-form-submit'] ) ) {
                                if ( empty( $_POST['register-form-password'] ) ) {
                                    echo '<div class="error">Password is required</div>';
                                }
                            }
                        ?>
                    </div>
                </div>


                <div class="form-group">
                    <label><?php esc_html_e( 'Repeat Password', 'mos' ); ?></label>
                    <input type="password" id="register-form-confirm-password" name="register-form-confirm-password"
                           class="form-input"
                           placeholder="<?php esc_attr_e( 'Repeat Password', 'mos' ); ?>"/>
                    <div id="login-status" class="login-status">
                        <?php
                            if ( isset( $_POST['register-form-submit'] ) ) {
                                if ( empty( $_POST['register-form-confirm-password'] ) ) {
                                    echo '<div class="error">Repeat Password is required</div>';
                                } elseif ( $_POST['register-form-password'] != $_POST['register-form-confirm-password'] ) {
                                    echo '<div class="error">Passwords do not match</div>';
                                }
                            }
                        ?>
                    </div>
                </div>


                <button type="submit" class="form-subscribe-button"
                        name="register-form-submit"><?php esc_html_e( 'Create Account', 'mos' ); ?></button>
            </form>
            <!-- eof: register form -->
        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
