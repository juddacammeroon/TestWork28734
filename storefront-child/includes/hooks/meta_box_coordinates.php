<?php

function register_city_meta() {
    register_post_meta('city', '_latitude', array(
        'type' => 'string',
        'description' => 'Latitude of the city',
        'single' => true,
        'show_in_rest' => true, // Important: this exposes the field in REST API
    ));
    register_post_meta('city', '_longitude', array(
        'type' => 'string',
        'description' => 'Longitude of the city',
        'single' => true,
        'show_in_rest' => true, // Important: this exposes the field in REST API
    ));
}
add_action('init', 'register_city_meta');

// Add the meta box
function add_coordinates_meta_box() {
    add_meta_box(
        'coordinates_meta_box', // Unique ID for the meta box
        'Coordinates',           // Box title
        'coordinates_meta_box_html',  // Callback function to display the fields
        'city',                  // Post type
        'side',                // Context (where to display)
        'default'                // Priority
    );
}
add_action('add_meta_boxes', 'add_coordinates_meta_box');

// HTML for the meta box
function coordinates_meta_box_html($post) {
    $latitude = get_post_meta($post->ID, '_latitude', true);
    $longitude = get_post_meta($post->ID, '_longitude', true);
    ?>
    <label for="latitude">Latitude</label>
    <div>
    	<input type="text" id="latitude" name="latitude" value="<?php echo esc_attr($latitude); ?>" />
    </div>
    <hr />
    <label for="longitude">Longitude</label>
    <div>
    	<input type="text" id="longitude" name="longitude" value="<?php echo esc_attr($longitude); ?>" />
    </div>
    <?php
}

// Save meta box data
function save_coordinates_meta_box_data($post_id) {
    if (array_key_exists('latitude', $_POST)) {
        update_post_meta($post_id, '_latitude', sanitize_text_field($_POST['latitude']));
    }
    if (array_key_exists('longitude', $_POST)) {
        update_post_meta($post_id, '_longitude', sanitize_text_field($_POST['longitude']));
    }
}
add_action('save_post', 'save_coordinates_meta_box_data');