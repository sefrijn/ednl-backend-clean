<?php

function add_favicon()
{
    echo '<link rel="shortcut icon" href="'.get_stylesheet_directory_uri().'/favicon.png"/>';
}
add_action('wp_head', 'add_favicon');
add_action('admin_head', 'add_favicon');
