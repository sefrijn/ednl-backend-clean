<?php

function webhooks()
{
    wp_enqueue_script(
        'webhooks',
        get_stylesheet_directory_uri() . '/js/postsave.js',
        array( 'wp-data', 'wp-compose', 'wp-dom-ready' ),
        '1.0',
        true
    );
    wp_localize_script('webhooks', 'deployment', array(
        'deployment_status' => get_field('deployment', 'options'),
        'github_key' => get_field('github_key', 'options'),
        'github_user' => get_field('github_user', 'options'),
        'repository_slug' => get_field('repository_slug', 'options')

    ));
}
add_action('enqueue_block_assets', 'webhooks');

if(function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Deployment',
        'capability'    => 'manage_options',
        'update_button' => __('Instellingen Opslaan', 'acf'),
        'updated_message' => __("De nieuwe deployment instellingen zijn opgeslagen", 'acf'),

    ));
}

add_action("save_post", 'action_save_post', 10, 3);

/**
 * Fires once a post has been saved.
 *
 * @param int      $post_ID Post ID.
 * @param \WP_Post $post    Post object.
 * @param bool     $update  Whether this is an existing post being updated.
 */
function action_save_post($post_ID, $post)
{
    if($post->post_type === "organisaties") {

        $new_fields = array();
        $fields = get_field('locaties', $post_ID);
        foreach ($fields as $key => $field) {
            if($key > 0) {
                // Delay request to GEO API
                usleep(550);
            }
            $adres = $field['adres'];
            $adres = preg_replace('/[\r\n]+/', ' ', $adres); // replace linebreaks and returns with a single plus sign
            $adres = preg_replace('/\s+/', ' ', $adres); // replace consecutive spaces with a single space
            $adres = preg_replace_callback('/\b\d{4}\s?[a-zA-Z]{2}\b/', function ($match) {
                return preg_replace('/\s/', '', $match[0]); // remove spaces from postal codes
            }, $adres);

            // cURL to GEO API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://geocode.maps.co/search?q=".urlencode($adres));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = json_decode(curl_exec($ch));
            curl_close($ch);

            $field["lonlat"] = json_encode(array($result[0]->lon, $result[0]->lat));
            $new_fields.array_push($new_fields, $field);
        }
        update_field('locaties', $new_fields, $post_ID);
    }
}
