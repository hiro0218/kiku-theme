<?php
// Access denied Author page
// -> update options-permalink
add_filter( 'author_rewrite_rules', '__return_empty_array' );

// Disable pingback XMLRPC method
function filter_xmlrpc_method($methods) {
    unset($methods['pingback.ping']);
    return $methods;
}
add_filter('xmlrpc_methods', 'filter_xmlrpc_method', 10, 1);

// Remove pingback header
function filter_headers($headers) {
    if (isset($headers['X-Pingback'])) {
        unset($headers['X-Pingback']);
    }
    return $headers;
}
add_filter('wp_headers', 'filter_headers', 10, 1);

// Disable trackback rewrite rule
function filter_rewrites($rules) {
    foreach ($rules as $rule => $rewrite) {
        if (preg_match('/trackback\/\?\$$/i', $rule)) {
            unset($rules[$rule]);
        }
    }
    return $rules;
}
add_filter('rewrite_rules_array', 'filter_rewrites');


// Disable bloginfo('pingback_url')
function disable_pingback_url($output, $show) {
    if ($show === 'pingback_url') {
        $output = '';
    }
    return $output;
}
add_filter('bloginfo_url', 'disable_pingback_url', 10, 2);

// Disable XMLRPC call
function disable_xmlrpc($action) {
    if ($action === 'pingback.ping') {
        wp_die('Pingbacks are not supported', 'Not Allowed!', ['response' => 403]);
    }
}
add_action('xmlrpc_call', 'disable_xmlrpc');

// Disable self-ping
function disable_self_ping($links) {
    $home = get_option('home');
    foreach ( $links as $l => $link ){
        if ( 0 === strpos( $link, $home ) ){
            unset($links[$l]);
        }
    }
}
add_action('pre_ping', 'disable_self_ping');

// Disable Redirect
function disable_completion_redirect($redirect_url) {
    if (is_404()) {
        return false;
    }
    return $redirect_url;
}
add_filter( 'redirect_canonical', 'disable_completion_redirect' );
