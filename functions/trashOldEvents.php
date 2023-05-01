<?php

// > Clear old events
add_action('init', 'trash_old_events');
function trash_old_events()
{
    $args = array(
        'post_type'			=> 'festival-of-retraite',
        'posts_per_page'	=> -1,
        'meta_key'			=> 'wanneer_einde',
        'meta_query' => array(
            array(
                'key' => 'wanneer_einde',
                'value' => date("Ymd"),
                'compare' => '<'
            )
        ),
        'orderby'			=> 'meta_value',
        'order'				=> 'ASC'
    );
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $post_id = get_the_ID();
            wp_trash_post($post_id);
        }
        wp_reset_postdata();
    }
}
