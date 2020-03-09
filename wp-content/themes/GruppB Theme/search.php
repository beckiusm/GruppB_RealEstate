<?php
//Detta printar ut resultatet när man har sökt

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
						
						$categoryName = $_GET["category_name"];
						$tagName = $_GET["tagName"];
						$searchInput = filter_input(INPUT_GET, 's', FILTER_DEFAULT);

						// $minRoom = $_GET['min_room'] ?? 0;
			
						$minRoom = sanitize_text_field( wp_unslash( $_GET['min_room'] ) );;
						$maxRoom = sanitize_text_field( wp_unslash( $_GET['max_room'] ) );;
						$minPrice = sanitize_text_field( wp_unslash( $_GET['min_price'] ) );;
						$maxPrice = sanitize_text_field( wp_unslash( $_GET['price'] ) );;

						if (isset($minRoom) || isset($maxRoom) || isset($minPrice) || isset($maxPrice)) {
							if ($maxRoom == '') {
								$maxRoom = 1000000000000;
							}
							if($maxPrice == '') {
								$maxPrice = 1000000000000;
							}
						}

						$args = array(
							'tag' => $tagName,
							'category_name' => $categoryName,
							's' => $searchInput,
							'meta_query' => array(
								'relation' => 'AND',
								array(
									'key' => 'rooms',
									'value' => array($minRoom, $maxRoom),
									'type' => 'numeric',
									'compare' => 'BETWEEN'
								),
								array(
									'key' => 'utgangsbud',
									'value' => array($minPrice, $maxPrice),
									'type' => 'numeric',
									'compare' => 'BETWEEN'
								)
							)
						);

						$the_query = new WP_Query( $args );
						

						include( locate_template( 'loop-templates/content-search.php', false, false ) );

					?>
				</main><!-- #main -->
			</div>
			<!-- Do the right sidebar check -->
			<?php get_search_form(); //get_template_part( 'sidebar-templates/sidebar-primary', 'right' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
