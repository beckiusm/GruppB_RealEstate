<?php

/**
 * Child theme
 */

function understrap_enqueue_styles() {
	$parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style(
		'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'understrap_enqueue_styles' );

/**
 * Change default post types shown on category page
 */

function query_post_type( $query ) {
	if ( $query->get( 'post_type' ) === 'nav_menu_item' ) {
		return $query;
	}
	if ( ( is_search() || is_home() || is_category() || is_tag() ) && ! is_admin() ) {
		$query->set( 'post_type', 'property' );
		return $query;
	}
}
add_filter( 'pre_get_posts', 'query_post_type' );

/**
 * Add our custom sidebar to the widget-area by using the hook 'widgets_init'
 */
function search_widget() {
	register_sidebar(
		array(
			'name'          => __( 'Primary Sidebar', 'gruppB' ),
			'id'            => 'sidebar-primary',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'search_widget' );

/**
 * 
 */
function advanced_search_query( $query ) {

	if ( $query->is_search() ) {

		// tag search
		if ( isset( $_GET['taglist'] ) && is_array( $_GET['taglist'] ) ) {
			$query->set( 'tag_slug__and', $_GET['taglist'] );
		}
		return $query;
	}

}
add_action( 'pre_get_posts', 'advanced_search_query', 1000 );

function cptui_register_my_cpts_property() {

	/**
	 * Post Type: Properties.
	 */

	$labels = array(
		'name'                     => __( 'Properties', 'gruppB' ),
		'singular_name'            => __( 'Property', 'gruppB' ),
		'menu_name'                => __( 'My Properties', 'gruppB' ),
		'all_items'                => __( 'All Properties', 'gruppB' ),
		'add_new'                  => __( 'Add new', 'gruppB' ),
		'add_new_item'             => __( 'Add new Property', 'gruppB' ),
		'edit_item'                => __( 'Edit Property', 'gruppB' ),
		'new_item'                 => __( 'New Property', 'gruppB' ),
		'view_item'                => __( 'View Property', 'gruppB' ),
		'view_items'               => __( 'View Properties', 'gruppB' ),
		'search_items'             => __( 'Search Properties', 'gruppB' ),
		'not_found'                => __( 'No Properties found', 'gruppB' ),
		'not_found_in_trash'       => __( 'No Properties found in trash', 'gruppB' ),
		'parent'                   => __( 'Parent Property:', 'gruppB' ),
		'featured_image'           => __( 'Featured image for this Property', 'gruppB' ),
		'set_featured_image'       => __( 'Set featured image for this Property', 'gruppB' ),
		'remove_featured_image'    => __( 'Remove featured image for this Property', 'gruppB' ),
		'use_featured_image'       => __( 'Use as featured image for this Property', 'gruppB' ),
		'archives'                 => __( 'Property archives', 'gruppB' ),
		'insert_into_item'         => __( 'Insert into Property', 'gruppB' ),
		'uploaded_to_this_item'    => __( 'Upload to this Property', 'gruppB' ),
		'filter_items_list'        => __( 'Filter Propertys list', 'gruppB' ),
		'items_list_navigation'    => __( 'Properties list navigation', 'gruppB' ),
		'items_list'               => __( 'Properties list', 'gruppB' ),
		'attributes'               => __( 'Properties attributes', 'gruppB' ),
		'name_admin_bar'           => __( 'Property', 'gruppB' ),
		'item_published'           => __( 'Property published', 'gruppB' ),
		'item_published_privately' => __( 'Property published privately.', 'gruppB' ),
		'item_reverted_to_draft'   => __( 'Property reverted to draft.', 'gruppB' ),
		'item_scheduled'           => __( 'Property scheduled', 'gruppB' ),
		'item_updated'             => __( 'Property updated.', 'gruppB' ),
		'parent_item_colon'        => __( 'Parent Property:', 'gruppB' ),
	);

	$args = array(
		'label'                 => __( 'Properties', 'gruppB' ),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'delete_with_user'      => false,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'rewrite'               => array(
			'slug'       => 'property',
			'with_front' => true,
		),
		'query_var'             => true,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
	);

	register_post_type( 'property', $args );
}

add_action( 'init', 'cptui_register_my_cpts_property' );

