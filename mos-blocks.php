<?php

    /**
     * Plugin Name:       Mos Blocks
     * Theme URI:         https: //github.com/wp-mos/wp-mos-blocks
     * Author:            Harpoon Team
     * Author URI:        https://harpoon.ro/
     * Description:       A plugin for adding custom blocks to Mos Theme.
     * Version:           1.0.0
     * Requires at least: 6.0
     * Requires PHP:      7.4
     * Text Domain:       mos
     * Domain Path:       languages
     */

    if ( ! function_exists( 'add_action' ) ) {
        echo 'Seems like you stumbled here by accident. 😛';
        exit;
    }

    // Setup
    define( 'MOS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

    // Includes
    $includes_files              = glob( MOS_PLUGIN_DIR . 'includes/*.php' );
    $includes_subdirectory_files = glob( MOS_PLUGIN_DIR . 'includes/**/*.php' );
    $all_includes_files          = array_merge( $includes_files, $includes_subdirectory_files );

    foreach ( $all_includes_files as $filename ) {
        include_once( $filename );
    }

    // Filters
    add_filter( 'block_categories_all', 'mos_register_blocks_category' );

    // Hooks
    add_action( 'rest_api_init', 'mos_rest_api_init' );
    add_action( 'init', 'mos_register_blocks' );
    add_action( 'wp_enqueue_scripts', 'mos_enqueue_scripts' );

    add_action( 'wp_loaded', 'mos_hide_admin_bar' );
    add_action( 'admin_init', 'mos_redirect_clients_to_frontend' );
    add_action( 'template_redirect', 'mos_redirect_if_not_logged_in' );
    add_action( 'template_redirect', 'mos_redirect_if_not_logged_in_en' );
    add_action( 'template_redirect', 'mos_redirect_if_not_logged_in_hu' );
    add_action( 'template_redirect', 'mos_redirect_if_logged_in' );

    add_action( 'init', 'mos_load_translations' );

