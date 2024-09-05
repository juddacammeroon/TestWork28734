<?php

function maju_get_includes($types = array()) {
	if (count($types) > 0) {
		foreach ($types as $type) {
			$files_dir = dirname(__FILE__) . '/includes/' . $type;

			if (is_dir($files_dir)) {
				$files = array_diff(scandir($files_dir), array('.', '..'));

				if ($type === 'blocks') {
					foreach ($files as $file) {
						$current_path = $files_dir . '/' . $file;

						if (is_dir($current_path)) {
							$path_files = array_diff(scandir($current_path), array('.', '..'));

							if (in_array($file . '.php', $path_files)) {
							// if (in_array('init.php', $path_files)) {
								require $current_path . '/' . $file . '.php';
								// require $current_path . '/init.php';
							}
						}
					}
				} else {
					if (count($files) > 0) {
						foreach ($files as $file) {
							require $files_dir . '/' .$file;
						}
					}
				}
			}
		}
	}
}

add_action('init', function(){
	add_theme_support( 'custom-logo' );
	add_theme_support( 'site-icon' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_post_type_support( 'page', 'excerpt' );

	$includes = array('blocks', 'functions', 'hooks');
	maju_get_includes($includes);

	load_post_types(
		array(
			array(
				'slug' => 'city',
				'singular' => 'City',
				'plural' => 'Cities',
				'dashicon' => 'dashicons-location-alt'
			)
		)
	);

	load_taxonomies(
		array(
			array(
				'name' => 'Country',
				'slug' => 'country',
				'post_type' => 'city',
				'singular' => 'Country',
				'plural' => 'Countries',
				'hierarchical' => true
			)
		)
	);
});