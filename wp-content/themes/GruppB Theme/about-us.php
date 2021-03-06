<?php

/*
* Template Name: About-us
*/
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

					<h1>Om oss test</h1>
					<?php
					if ( have_posts() ) {
						the_post();
						the_content();
					}

					?>
				</main><!-- #main -->


				<!-- The pagination component -->
				<?php

				understrap_pagination();
				?>
			</div>

			<!-- Do the primary sidebar check -->
			

			<!--Denna del krävs för att sidebaren ska visa det som läggs till i widgets menyn -->
			<?php
			if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'sidebar-primary' ) ) :
				get_template_part( 'sidebar-templates/sidebar', 'primary' );
			endif;
			?>
		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>