<?php

/*
 * Add columns to Festivals and Retreats
 */
function add_acf_columns($columns)
{
    return array_merge($columns, array(
      'wanneer_start' => __('Start'),
      'wanneer_einde'   => __('Einde')
    ));
}
add_filter('manage_festival-of-retraite_posts_columns', 'add_acf_columns');

function custom_column($column, $post_id)
{
    switch ($column) {
        case 'wanneer_start':
            echo wp_date(get_option('date_format'), strtotime(get_post_meta($post_id, 'wanneer_start', true)));
            break;
        case 'wanneer_einde':
            echo wp_date(get_option('date_format'), strtotime(get_post_meta($post_id, 'wanneer_einde', true)));
            break;
    }
}
add_action('manage_festival-of-retraite_posts_custom_column', 'custom_column', 10, 2);
