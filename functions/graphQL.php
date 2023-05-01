<?php

// Post type Organisaties in GraphQL
function graphql_custom($args, $post_type)
{
    if ($post_type == "organisaties") {
        $args['show_in_graphql'] = true;
        $args['graphql_single_name'] = 'organisation';
        $args['graphql_plural_name'] = 'organisations';
    }
    if ($post_type == "festival-of-retraite") {
        $args['show_in_graphql'] = true;
        $args['graphql_single_name'] = 'festivalOfRetraite';
        $args['graphql_plural_name'] = 'festivalsEnRetraites';
    }
    return $args;
}
add_filter('register_post_type_args', 'graphql_custom', 20, 2);
