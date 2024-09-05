<?php

function register_custom_city_endpoint() {
    register_rest_route('custom/v1', '/city/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_city_meta_data',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'register_custom_city_endpoint');

function get_city_meta_data($data) {
    $city_id = $data['id'];
    $city_obj = get_post($city_id);
    $latitude = get_post_meta($city_id, '_latitude', true);
    $longitude = get_post_meta($city_id, '_longitude', true);
    $city = $city_obj->post_title;

    return array(
        'latitude' => $latitude,
        'longitude' => $longitude,
        'city' => $city
    );
}