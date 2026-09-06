<?php

/**
 * تغییر آدرس صفحه لاگین وردپرس
 * 
 * این کدها به فایل functions.php قالب اضافه می‌شوند.
 * برای تغییر آدرس، مقدار 'your-url.php' را به آدرس دلخواه خود تغییر دهید.
 */

function custom_login_redirect() {
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, '/wp-login.php') !== false || $request_uri === '/wp-admin') {
        wp_redirect(home_url('/your-url.php')); // Add your custom address
        exit;
    }
}
add_action('init', 'custom_login_redirect');


function custom_logout_redirect() {
    return home_url('/your-url.php'); // Add your custom address
}
add_filter('logout_url', 'custom_logout_redirect', 10, 2);


add_action('init', 'block_wp_admin_for_guests');
function block_wp_admin_for_guests() {
    if ( !is_user_logged_in() && strpos($_SERVER['REQUEST_URI'], '/wp-admin') !== false ) {
        if ( !wp_doing_ajax() && !wp_is_json_request() ) {
            status_header(404);
            nocache_headers();
            include( get_404_template() );
            exit;
        }
    }
}

?>
