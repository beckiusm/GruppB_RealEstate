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

class Jonas_Widget extends WP_Widget {
 
    function __construct() {
 
        parent::__construct(
            'Jonas_Widget',  // Base ID
            'Jonas_Widget'   // Name
        );
 
        add_action( 'widgets_init', function() {
            register_widget( 'Jonas_Widget' );
        });
 
    }
 
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {
 
        echo $args['before_widget'];
 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
 
        echo '<div class="textwidget">';
 
        echo esc_html__( $instance['text'], 'text_domain' );
        $loop = new WP_Query([
            'post_type'      => 'property',
            'meta_key'       => 'visning',
            'orderby'        => 'meta_value',
            'order'         => 'ASC',
        ]);

        while($loop->have_posts()) {
            $loop->the_post();
            echo '<p>' . esc_html( 'Adress: ' . get_field('address') ) . '<br>';
            echo  esc_html( 'Boarea: ' . get_field('boarea') ) . ' m2 </p>';;
        }

        echo '</div>';
 
        echo $args['after_widget'];
 
    }
 
    public function form( $instance ) {
 
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        $text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'Text' ) ); ?>"><?php echo esc_html__( 'Text:', 'text_domain' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" cols="30" rows="10"><?php echo esc_attr( $text ); ?></textarea>
        </p>
        <?php
 
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();
 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['text'] = ( !empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
 
        return $instance;
    }
 
}
$Jonas_Widget = new Jonas_Widget();
?>