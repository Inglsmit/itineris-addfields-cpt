<?php
/**
 * Plugin Name:       Iteneris - additional fileds for course CPT.
 * Description:       Plugin add additional fileds for course CPT.
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Paul Inglsmit
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       itineris-sidebar-opt
 *
 */

function itineris_sidebar_opt_enqueue_assets() {

    $asset_file = include(plugin_dir_path( __FILE__ ) . 'build/index.asset.php');

    wp_enqueue_script( 'itineris-sidebar-opt-script', plugins_url('build/index.js', __FILE__), $asset_file['dependencies'], $asset_file['version']);

}

add_action( 'enqueue_block_editor_assets', 'itineris_sidebar_opt_enqueue_assets' );

// function itineris_sidebar_opt_sanitize_boolean_field( $meta_value ) {
//     return ( isset($meta_value) && $meta_value === true ) ? true : false;
// }

function itineris_sidebar_opt_sanitize_number_field( $meta_value ) {
    return ( intval($meta_value) ) ? true : false;
}

function itineris_sidebar_opt_register_meta() {
    register_meta( 'post', '_itineris_sidebar_opt_duartion_meta', array(
        'object_subtype' => 'itineris_course',
        'single' => true,
        'type' => 'string',
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => function() {
            return current_user_can( 'edit_posts' );
        }
    ));
	register_meta( 'post', '_itineris_sidebar_opt_code_url_meta', array(
        'object_subtype' => 'itineris_course',
        'single' => true,
        'type' => 'string',
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => function() {
            return current_user_can( 'edit_posts' );
        }
    ));

}
add_action( 'init', 'itineris_sidebar_opt_register_meta' );

