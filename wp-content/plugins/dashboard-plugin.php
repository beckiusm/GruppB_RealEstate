<?php
/*
    Plugin Name: dashboard-plugin
    Plugin URI:  http://link to your plugin homepage
    Description: Describe what your plugin is all about in a few short sentences
    Version:     1.0
    Author:      Jonas Gertz
    Author URI:  http://link to your website
    License:     GPL2 etc
    License URI: http://link to your plugin license
*/

/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function wporg_add_dashboard_widgets()
{
    wp_add_dashboard_widget(
        'wporg_dashboard_widget',                          // Widget slug.
        esc_html__('Display chosen properties', 'wporg'), // Title.
        'wporg_dashboard_widget_render'                    // Display function.
    );
}
add_action('wp_dashboard_setup', 'wporg_add_dashboard_widgets');

/**
 * Create the function to output the content of our Dashboard Widget.
 */
function wporg_dashboard_widget_render()
{
    // Display whatever you want to show.

?>
    <h1>Utvalda fastigheter</h1>
    <?php
    $wp_query = new WP_Query(
        array(
            'post_type' => 'property',
            'meta_key' => 'utvalt_objekt',
            'meta_value' => true,
        )
    );
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        the_title();
        echo " has id: " . get_the_ID();
        echo "<a href=" . get_the_permalink() . "> View Property </a>";
        echo "<br>";
    }

    $wp_query = new WP_Query(
        array(
            'post_type' => 'property',
            'meta_key' => 'utvalt_objekt',
            'meta_value' => 0,
        )
    );
    //var_dump($wp_query);
    echo "<br>"; ?>
    <h1>Övriga fastigheter</h1>
<?php
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        the_title();
        echo " has id: " . get_the_ID();
        echo "<a href=" . get_the_permalink() . "> View Property </a>";
        echo "<br>";
    }
}
