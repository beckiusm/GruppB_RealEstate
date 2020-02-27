<?php

/**
 * Child theme
 */

function understrap_enqueue_styles()
{
	$parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
	wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
	wp_enqueue_style(
		'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array($parent_style),
		wp_get_theme()->get('Version')
	);
}
add_action('wp_enqueue_scripts', 'understrap_enqueue_styles');

/**
 * Change amount of posts on frontpage
 */

/* function front_page_posts( $query ) {
	if ( is_home() ) {
		$query->set( 'posts_per_page', 6 );
	}
}
add_action( 'pre_get_posts', 'front_page_posts' ); */

/**
 * Change default post types shown on category page
 */

function query_post_type($query)
{
	if ((is_home() || is_category() || is_tag()) && !is_admin()) {
		$query->set('post_type', 'property');
		return $query;
	}
}
add_filter('pre_get_posts', 'query_post_type');


/**
 * Jonas testar göra en custom sidebar
 * 
 */
/*
add_action( 'widgets_init', 'my_register_sidebars' );
function my_register_sidebars() {
    /* Register the 'primary' sidebar. 
    register_sidebar(
        array(
            'id'            => 'primary',
            'name'          => __( 'Primary Sidebar' ),
            'description'   => __( 'A short description of the sidebar.' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
     Repeat register_sidebar() code for additional sidebars. 
}*/

add_action('widgets_init', 'my_register_sidebars');
function my_register_sidebars()
{
	/* Register the 'primary' sidebar. */
	register_sidebar(
		array(
			'id'            => 'primary',
			'name'          => __('Primary Sidebar'),
			'description'   => __('GruppB Sidebar'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	/* Repeat register_sidebar() code for additional sidebars. */
}
