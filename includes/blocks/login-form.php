<?php

  function mos_login_form()
  {
    if (is_user_logged_in()) {
      return '';
    }

    $output = '';
    $login_data = array();

    if (isset($_POST['login-form-email']) && isset($_POST['login-form-password'])) {
      $email = sanitize_email($_POST['login-form-email']);
      $password = sanitize_text_field($_POST['login-form-password']);

      if (empty($email)) {
        $output .= '<div class="login-error">' . esc_html__('Email is required.', 'text-domain') . '</div>';
      } else if (!is_email($email)) {
        $output .= '<div class="login-error">' . esc_html__('Invalid email address.', 'text-domain') . '</div>';
      }

      if (empty($password)) {
        $output .= '<div class="login-error">' . esc_html__('Password is required.', 'text-domain') . '</div>';
      }

      if (empty($output)) {
        $login_data['user_login'] = $email;
        $login_data['user_password'] = $password;
        $login_data['remember'] = true;

        $user = wp_signon($login_data, false);
        if (is_wp_error($user)) {
          $output .= '<div class="login-error">' . esc_html__('Invalid login credentials.', 'text-domain') . '</div>';
        } else {
          // Generate and store a token for the user
          $token = wp_generate_password(32);
          update_user_meta($user->ID, 'auth_token', $token);

          // Set the token as a cookie
          setcookie('auth_token', $token, time() + (86400 * 30), "/"); // Cookie will expire in 30 days
          wp_set_auth_cookie($user->ID);
          wp_safe_redirect(home_url() . '/utilizatori/comanda-noua/');
          exit;
        }
      }
    }

    ob_start(); ?>

      <div class="wp-block-mos-blocks-login-form">
          <!-- sof: login form -->
          <form id="login-form" class="login-form" method="post">
              <div id="login-status" class="login-status"><?php echo $output; ?></div>

              <div class="form-group">
                  <label for="login-form-email"><?php esc_html_e('Email', 'text-domain'); ?></label>
                  <input type="text" id="login-form-email" name="login-form-email" class="form-input"
                         placeholder="<?php esc_attr_e('Email', 'text-domain'); ?>"
                         value="<?php echo isset($_POST['login-form-email']) ? esc_attr($_POST['login-form-email']) : ''; ?>"/>
              </div>

              <div class="form-group">
                  <label for="login-form-password"><?php esc_html_e('Parola', 'text-domain'); ?></label>
                  <input type="password" id="login-form-password" name="login-form-password" class="form-input"
                         placeholder="<?php esc_attr_e('Parola', 'text-domain'); ?>"/>
              </div>

              <div class="form-footer">
                  <div class="form-footer-meta">
                    <?php esc_html_e('Nu ai inca cont?', 'text-domain'); ?>
                      <a class="animated-link"
                         href="<?php echo esc_url(site_url('/utilizatori/inregistrare')); ?>"><?php esc_html_e('Inregistreza-te', 'text-domain'); ?></a>
                  </div>
                  <button class="form-subscribe-button"
                          type="submit"><?php esc_html_e('Intră în cont', 'text-domain'); ?></button>
              </div>

          </form>
          <!-- eof: login form -->
      </div>

    <?php
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
  }
