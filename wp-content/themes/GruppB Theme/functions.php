<?php
add_action( 'wp_enqueue_scripts', 'understrap_enqueue_styles' );
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

function front_page_posts( $query ) {
	if ( is_home() ) {
		$query->set( 'posts_per_page', 6 );
	}
}
add_action( 'pre_get_posts', 'front_page_posts' );

add_filter( 'pre_get_posts', 'query_post_type' );
function query_post_type( $query ) {
	if ( ( is_category() || is_tag() ) && ! is_admin() ) {
		$query->set( 'post_type', 'property' );
		return $query;
	}
}
