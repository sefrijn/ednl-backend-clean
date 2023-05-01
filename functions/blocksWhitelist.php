<?php

// Limit allowed blocks in Wordpress Gutenberg editor
function gute_whitelist_blocks($allowed_block_types)
{
    return array(
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/image',
        'core/gallery',
        'core/embed',
        'core/spacer'
    );
}
add_filter('allowed_block_types', 'gute_whitelist_blocks', 10, 2);

function wpb_embedblock()
{
    wp_enqueue_script(
        'allow-list-blocks',
        get_stylesheet_directory_uri() . '/js/blockembed.js',
        array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
    );
}
add_action('enqueue_block_editor_assets', 'wpb_embedblock');
