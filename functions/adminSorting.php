<?php

is_admin() && add_action('pre_get_posts', 'extranet_orderby', 9);

function extranet_orderby($query)
{
    // Nothing to do
    if(! $query->is_main_query() || 'organisaties' != $query->get('post_type')) {
        return;
    }
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
}
