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


add_action('restrict_manage_posts', 'property_filter_posts_by_complete');
function property_filter_posts_by_complete()
{
	$type = $_GET['post_type'] ?? 'property';
	// Only add filter to post type you want.
	if ('property' == $type) {
		$values = array(
			'Utvald' => 'complete',
			'Icke-utvald' => 'incomplete',
		);
	?>
		<select name="status">
			<option value=""><?php _e('Alla statusar'); ?></option>
			<?php
			$current_v = $_GET['status'] ?? '';
			foreach ($values as $label => $value) {
				printf(
					'<option value="%s"%s>%s</option>',
					$value,
					$value == $current_v ? ' selected="selected"' : '',
					$label
				);
			}
			?>
		</select>
<?php
	}
}
add_filter( 'parse_query', 'property_filter' );
function property_filter( $query )
{
	global $pagenow;
	$type = $_GET['post_type'] ?? 'property';
	$status = $_GET['status'] ?? '';
	if ('property' == $type && is_admin() && $pagenow == 'edit.php' && $status != '') {
		$query->query_vars['meta_key'] = 'utvalt_objekt';
		if ('complete' == $status) {
			$query->query_vars['meta_value'] = 1;
		}
		if ('incomplete' == $status) {
			$query->query_vars['meta_value'] = [0];
		}
	}
}
add_filter( 'manage_property_posts_columns', 'custom_property_sortable_columns' );
function custom_property_sortable_columns( $columns )
{
	$columns['complete'] = __('Utvalda', 'dashboard-plugin');
	return $columns;
}
// Populate columns with data
add_action('manage_property_posts_custom_column', 'custom_property_column', 10, 2);
function custom_property_column($column, $post_id)
{
	// Status column
	if ( 'complete' === $column ) {
		$value = get_post_meta( $post_id, 'utvalt_objekt', true );
		echo $value ? 'Utvald' : 'Icke-utvald';
	}
}