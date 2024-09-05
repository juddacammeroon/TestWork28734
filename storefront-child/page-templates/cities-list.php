<?php
/*
Template Name: Cities Table
*/

get_header();

// Fetch all countries (taxonomy terms)
$country_terms = get_terms(array(
    'taxonomy' => 'country',
    'hide_empty' => false,
));

// Get API Key and Base URL for OpenWeatherMap
$api_key = 'c34faa787c3c0e3df9f3a5410ae189e2'; // Replace with your API key
$api_base_url = 'https://api.openweathermap.org/data/2.5/weather';

// Prepare query for cities
global $wpdb;
$cities = $wpdb->get_results("
    SELECT p.ID, p.post_title
    FROM {$wpdb->posts} p
    WHERE p.post_type = 'city' AND p.post_status = 'publish'
");

// Fetch temperature for each city from OpenWeatherMap API
$city_temperatures = array();
foreach ($cities as $city) {
    $city_name = urlencode($city->post_title);
    
    // Fetch temperature from OpenWeatherMap API
    $response = wp_remote_get("{$api_base_url}?q={$city_name}&appid={$api_key}&units=metric");
    if (is_wp_error($response)) {
        continue;
    }
    
    $data = json_decode(wp_remote_retrieve_body($response), true);
    if (isset($data['main']['temp'])) {
        $city_temperatures[$city->ID] = $data['main']['temp'];
    } else {
        $city_temperatures[$city->ID] = 'Unavailable';
    }
}

?>

<div class="container">
    <h1>Cities and Countries</h1>

    <!-- Search form -->
    <input type="text" id="city-search" placeholder="Search for a city...">

    <!-- Table for displaying data -->
    <table>
        <thead>
            <tr>
                <th>City</th>
                <th>Country</th>
                <th>Temperature (°C)</th>
            </tr>
        </thead>
        <tbody id="city-table-body">
            <?php foreach ($cities as $city): ?>
                <tr>
                    <td><?php echo esc_html($city->post_title); ?></td>
                    <td>
                        <?php
                        // Get countries associated with this city
                        $terms = wp_get_post_terms($city->ID, 'country');
                        echo implode(', ', wp_list_pluck($terms, 'name'));
                        ?>
                    </td>
                    <td><?php echo esc_html($city_temperatures[$city->ID] ?? 'Error'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php get_footer(); ?>

<script>
    // AJAX search functionality
    document.getElementById('city-search').addEventListener('keyup', function() {
        var query = this.value.toLowerCase();
        var rows = document.querySelectorAll('#city-table-body tr');

        rows.forEach(function(row) {
            var cityName = row.children[0].textContent.toLowerCase();
            if (cityName.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>