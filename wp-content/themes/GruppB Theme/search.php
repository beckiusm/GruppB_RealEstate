<?php
// Detta printar ut resultatet när man har sökt

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper container-fluid" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md content-area" id="primary">

				<main class="site-main content" id="main">
					<h1>Sökresultat</h1>

					<?php

					if ( isset( $_GET['category_name'] ) ) {
						$category_name = sanitize_text_field( wp_unslash( $_GET['category_name'] ) );
					}
					if ( isset( $_GET['min_room'] ) ) {
						$min_room = sanitize_text_field( wp_unslash( $_GET['min_room'] ) );
					}
					if ( isset( $_GET['max_room'] ) ) {
						$max_room = sanitize_text_field( wp_unslash( $_GET['max_room'] ) );
					}
					if ( isset( $_GET['min_price'] ) ) {
						$min_price = sanitize_text_field( wp_unslash( $_GET['min_price'] ) );
					}
					if ( isset( $_GET['max_price'] ) ) {
						$max_price = sanitize_text_field( wp_unslash( $_GET['max_price'] ) );
					}
					if ( isset( $_GET['s'] ) ) {
						$search_input = sanitize_text_field( wp_unslash( $_GET['s'] ) );
					}
					if ( '' === $max_room ) {
						$max_room = 1000000000000;
					}
					if ( '' === $max_price ) {
						$max_price = 1000000000000;
					}
					$args     = array(
						'category_name' => $category_name,
						's'             => $search_input,
						'paged'         => $paged,
						'meta_query'    => array(
							'relation' => 'AND',
							array(
								'key'     => 'rooms',
								'value'   => array( $min_room, $max_room ),
								'type'    => 'numeric',
								'compare' => 'BETWEEN',
							),
							array(
								'key'     => 'utgangsbud',
								'value'   => array( $min_price, $max_price ),
								'type'    => 'numeric',
								'compare' => 'BETWEEN',
							),
						),
					);
					$wp_query = new WP_Query( $args );
					get_template_part( 'loop-templates/content', 'search' );
					?>
				</main><!-- #main -->
			</div>
			<!-- Do the right sidebar check -->
			<?php get_search_form(); // get_template_part( 'sidebar-templates/sidebar-primary', 'right' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
