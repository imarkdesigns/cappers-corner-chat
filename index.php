<?php
/*
Plugin Name: Cappers Corner Chat
Plugin URI: https://stupendousweb.com
Description: Renders a branded chatroom as a shortcode, using a local database migration, and Ultimate Member for authentication
Author: Stupendous Web Marketing
Version: 1
Author URI: https://stupendousweb.com
*/

/****************/
/* API Requests */
/****************/

include 'api.php';

/**************/
/* Activation */
/**************/

function activate() {

    // If Ultimate Plugin is installed, migrate the database tables

    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    if (is_plugin_active('ultimate-member/ultimate-member.php')) {
        include 'migrate.php';
    } else {
        die('Please install and enable the Ultimate Member plugin and try again.');
    }
}
register_activation_hook(__FILE__, 'activate');

/*************/
/* Front End */
/*************/

function chat() {

    // Load jQuery with AJAX API URL

    wp_enqueue_script('jquery');
    wp_enqueue_script('uikit', 'https://cdn.jsdelivr.net/npm/uikit@3.9.1/dist/js/uikit-icons.min.js"');
    wp_enqueue_script('scripts', '/wp-content/plugins/cappers-corner-chat/scripts.js');
    wp_localize_script('scripts', 'Obj', [
        'url' => admin_url('admin-ajax.php'),
    ]);

    // Page HTML

    include 'chat.php';
}
add_shortcode( 'cappers-corner-chat', 'chat');

/************/
/* Back End */
/************/

function dashboard() {

    // Load UI Kit Scripts

    wp_enqueue_style('uikit', 'https://cdn.jsdelivr.net/npm/uikit@3.9.1/dist/css/uikit.min.css');
    wp_enqueue_script('uikit', 'https://cdn.jsdelivr.net/npm/uikit@3.9.1/dist/js/uikit.min.js');

    // Page HTML

    include 'dashboard.php';

}
add_action('admin_menu', 'admin');
function admin() {
    add_menu_page('CC Chat', 'CC Chat', 'manage_options', 'cc-chat', 'dashboard');
}