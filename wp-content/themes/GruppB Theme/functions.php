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


function front_page_posts( $query ) {
	if ( is_home() ) {
		$query->set( 'posts_per_page', 5 );
	}
}
add_action( 'pre_get_posts', 'front_page_posts' );

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
