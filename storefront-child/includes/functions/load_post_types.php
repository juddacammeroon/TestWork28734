<?php

function load_post_types($post_types = array()) {
	if (count($post_types) > 0) {
		foreach ($post_types as $post_type) {
			$labels = array(
				'name'               => _x( $post_type['plural'], 'post type general name', 'maju' ),
				'singular_name'      => _x( $post_type['singular'], 'post type singular name', 'maju' ),
				'menu_name'          => _x( $post_type['plural'], 'admin menu', 'maju' ),
				'name_admin_bar'     => _x( $post_type['singular'], 'add new on admin bar', 'maju' ),
				'add_new'            => _x( 'Add New', $post_type['singular'], 'maju' ),
				'add_new_item'       => __( 'Add New '.$post_type['singular'], 'maju' ),
				'new_item'           => __( 'New '.$post_type['singular'], 'maju' ),
				'edit_item'          => __( 'Edit '.$post_type['singular'], 'maju' ),
				'view_item'          => __( 'View '.$post_type['singular'], 'maju' ),
				'all_items'          => __( 'All '.$post_type['plural'], 'maju' ),
				'search_items'       => __( 'Search '.$post_type['plural'], 'maju' ),
				'parent_item_colon'  => __( 'Parent '.$post_type['plural'].':', 'maju' ),
				'not_found'          => __( 'No '.$post_type['plural'].' found.', 'maju' ),
				'not_found_in_trash' => __( 'No '.$post_type['plural'].' found in Trash.', 'maju' )
			);

			$args = array(
				'labels'      => $labels,
				'public'      => true,
				'has_archive' => true,
				'show_in_rest' => true,
				'supports' => array('title', 'editor', 'thumbnail', 'author'),
				'menu_icon'   => $post_type['dashicon']
			);

			if (isset($post_type['rewrite']) && $post_type['rewrite'] != '') {
				$args['rewrite'] = array( 'slug' => $post_type['rewrite'] );
			}

			if (isset($post_type['gutenberg'])) {
				$args['show_in_rest'] = $post_type['gutenberg'];
			}

			register_post_type($post_type['slug'], $args);
		}
	}
}