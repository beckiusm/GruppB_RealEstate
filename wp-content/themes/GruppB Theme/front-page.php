<?php

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
					<h1 class="display-4 d-flex justify-content-center">Utvalda bostäder</h1>
					<?php
					if ( have_posts() ) :
						get_template_part( 'loop-templates/content', 'utvalt' );
						?>
						<h2 class="display-4 d-flex justify-content-center">Övriga bostäder</h1>
						<?php
						get_template_part( 'loop-templates/content', 'other' );
					else :
						get_template_part( 'loop-templates/content', 'none' );
					endif;
					?>

				</main><!-- #main -->
			</div>
			<!-- Do the right sidebar check -->
			<?php get_template_part( 'sidebar-templates/sidebar-primary', 'right' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
