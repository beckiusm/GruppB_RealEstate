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
						
						if ($_GET["category_name"] === "") {

							echo "the tag: " . $_GET["tagName"];
							
							$the_query = new WP_Query( 'tag=' . $_GET["tagName"] );

							if ( $the_query->have_posts() ) {
								echo '<ul>';
								while ( $the_query->have_posts() ) {
									$the_query->the_post();
									echo '<li>' . get_the_title() . '</li>';
								}
								echo '</ul>';
							} else {
								echo "no posts found";
							}

						} elseif ( have_posts() ) {
							echo "kategori valdes och det fanns poster";
						} else {
							echo "funkade inte";
						}
						

					// if ( have_posts() ) :
					// 	echo "det finns poster eller tags";
					// 	//get_template_part( 'loop-templates/content', 'search' );
					// else :
					// 	echo "det finns inga posters";
					// 	//get_template_part( 'loop-templates/content', 'none' );
					// endif;
					?>
				</main><!-- #main -->
			</div>
			<!-- Do the right sidebar check -->
			<?php //get_search_form(); //get_template_part( 'sidebar-templates/sidebar-primary', 'right' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
