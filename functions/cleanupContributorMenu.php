<?php

function hide_siteadmin()
{
    if (current_user_can('contributor')) {
        remove_menu_page('tools.php');
        remove_menu_page('index.php');
        // Verberg festivals voor nu
        // remove_menu_page('edit.php?post_type=festival-of-retraite');
    }
}
add_action('admin_menu', 'hide_siteadmin');

function dashboard_redirect()
{
    if (current_user_can('contributor')) {
        wp_redirect(admin_url('edit.php?post_type=organisaties'));
    } else {
        return admin_url('index.php');
    }
}
add_action('load-index.php', 'dashboard_redirect');

function login_redirect($redirect_to, $request, $user)
{
    if (current_user_can('contributor') || current_user_can('administrator')) {
        return admin_url('edit.php?post_type=organisaties');
    } else {
        return admin_url('index.php');
    }
}
add_filter('login_redirect', 'login_redirect', 10, 3);
