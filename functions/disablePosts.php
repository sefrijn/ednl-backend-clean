<?php

// Remove default Posts
function post_remove()
{
    remove_menu_page('edit.php');
}
add_action('admin_menu', 'post_remove');
add_action('admin_bar_menu', 'remove_default_post_type_menu_bar', 999);
function remove_default_post_type_menu_bar($wp_admin_bar)
{
    $wp_admin_bar->remove_node('new-post');
}
