<?php

function load_taxonomies($taxonomies = array()) {
	if (count($taxonomies) > 0) {
		foreach ($taxonomies as $taxonomy) {
			$labels = array(
				'name' => _x( $taxonomy['name'], 'taxonomy general name', 'maju' ),
				'singular_name' => _x( $taxonomy['singular'], 'taxonomy singular name', 'maju' ),
				'search_items' => __( 'Search '.$taxonomy['plural'], 'maju' ),
				'popular_items' => __( 'Popular '.$taxonomy['plural'], 'maju' ),
				'all_items' => __( 'All '.$taxonomy['plural'], 'maju' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit '.$taxonomy['singular'], 'maju' ),
				'update_item' => __( 'Update '.$taxonomy['singular'], 'maju' ),
				'add_new_item' => __( 'Add New '.$taxonomy['singular'], 'maju' ),
				'new_item_name' => __( 'New '.$taxonomy['singular'].' Name', 'maju' ),
				'separate_items_with_commas' => __( 'Separate '.$taxonomy['plural'].' with commas', 'maju' ),
				'add_or_remove_items' => __( 'Add or remove '.$taxonomy['plural'], 'maju' ),
				'choose_from_most_used' => __( 'Choose from the most used '.$taxonomy['plural'], 'maju' ),
				'menu_name' => __( $taxonomy['name'] ),
			);

			$args = array(
				'hierarchical' => $taxonomy['hierarchical'],
				'labels' => $labels,
				'show_ui' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'show_in_rest' => true
			);

			if (isset($taxonomy['rewrite']) && $taxonomy['rewrite'] != '') {
				$args['rewrite'] = array( 'slug' => $taxonomy['rewrite'] );
			}

			if (isset($taxonomy['gutenberg']) && $taxonomy['gutenberg'] != '') {
				$args['show_in_rest'] = $taxonomy['gutenberg'];
			}
			
			register_taxonomy($taxonomy['slug'],$taxonomy['post_type'], $args);
		}
	}
}