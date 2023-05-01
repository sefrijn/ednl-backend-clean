<?php

// Contributor capabilities
function contributor_capibilities()
{
    $role = get_role('contributor');
    $role->add_cap('edit_published_organisations');
    $role->add_cap('edit_organisations');
    $role->add_cap('publish_organisations');
    $role->add_cap('delete_organisations');
    $role->add_cap('delete_published_organisations');
    $role->add_cap('read_organisations');
    $role->add_cap('upload_files');

    $role->add_cap('edit_event');
    // $role->remove_cap('publish_event');
    $role->add_cap('read_event');
    $role->add_cap('edit_events');
    // $role->remove_cap('publish_events');
    $role->add_cap('read_events');

}

add_action('init', 'contributor_capibilities');

// Limit media library access for contributors
function show_current_user_attachments($query)
{
    $user_id = get_current_user_id();
    if ($user_id && !current_user_can('activate_plugins') && !current_user_can('edit_others_posts')) {
        $query['author'] = $user_id;
    }
    return $query;
}
add_filter('ajax_query_attachments_args', 'show_current_user_attachments');

// Administrator capabilities
function admin_capabilities()
{
    $admin = get_role('administrator');
    $admin->add_cap('edit_published_organisations');
    $admin->add_cap('edit_organisations');
    $admin->add_cap('edit_others_organisations');
    $admin->add_cap('publish_organisations');
    $admin->add_cap('delete_organisations');
    $admin->add_cap('delete_published_organisations');
    $admin->add_cap('delete_others_organisations');
    $admin->add_cap('read_organisations');


    $admin->add_cap('edit_event');
    $admin->add_cap('publish_event');
    $admin->add_cap('read_event');
    $admin->add_cap('edit_events');
    $admin->add_cap('edit_others_events');
    $admin->add_cap('edit_published_events');
    $admin->add_cap('publish_events');
    $admin->add_cap('read_events');
    $admin->add_cap('delete_events');
    $admin->add_cap('delete_published_events');
    $admin->add_cap('delete_others_events');

}
add_action('init', 'admin_capabilities');
