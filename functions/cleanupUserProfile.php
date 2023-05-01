<?php

/*
Cleanup User Profile
*/
function admin_color_scheme()
{
    global $_wp_admin_css_colors;
    $_wp_admin_css_colors = [];
}
add_action('admin_head', 'admin_color_scheme');
if (! function_exists('cor_remove_personal_options')) {
    function cor_remove_personal_options($subject)
    {
        $subject = preg_replace('#<tr class="user-rich-editing-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Visual Editor" field
        $subject = preg_replace('#<tr class="user-comment-shortcuts-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Keyboard Shortcuts" field
        $subject = preg_replace('#<tr class="user-display-name-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Display name publicly as" field
        $subject = preg_replace('#<h2>'.__("Contact Info").'</h2>#s', '', $subject, 1); // Remove the "Contact Info" title
        $subject = preg_replace('#<tr class="user-url-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Website" field
        $subject = preg_replace('#<h2>'.__("About Yourself").'</h2>#s', '', $subject, 1); // Remove the "About Yourself" title
        $subject = preg_replace('#<tr class="user-description-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Biographical Info" field
        $subject = preg_replace('#<tr class="user-profile-picture(.*?)</tr>#s', '', $subject, 1); // Remove the "Profile Picture" field
        return $subject;
    }

    function cor_profile_subject_start()
    {
        if (! current_user_can('manage_options')) {
            ob_start('cor_remove_personal_options');
        }
    }

    function cor_profile_subject_end()
    {
        if (! current_user_can('manage_options')) {
            ob_end_flush();
        }
    }
}
add_action('admin_head', 'cor_profile_subject_start');
add_action('admin_footer', 'cor_profile_subject_end');
