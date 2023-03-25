<?php

  function mos_register_blocks(): void
  {
    $blocks = [
      ['name' => 'auth-button', 'options' => ['render_callback' => 'mos_auth_button']],
      ['name' => 'login-form', 'options' => ['render_callback' => 'mos_login_form']],
      ['name' => 'register-form', 'options' => ['render_callback' => 'mos_register_form']],
    ];

    foreach ($blocks as $block) {
      register_block_type(
        MOS_PLUGIN_DIR . 'build/blocks/' . $block['name'],
        $block['options'] ?? []
      );
    }
  }
