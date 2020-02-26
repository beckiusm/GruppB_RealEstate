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

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main content" id="main">
				<h1>Utvalda bostäder</h1>
				<?php if ( have_posts() ) : ?>

					<?php
					// Prepare query
					$loop = new WP_Query(
						array(
							'post_type' => 'property',
						)
					);

					// Första loopen för att skriva ut utvalda
					if ( $loop->have_posts() ) :
						?>
					<div class="row mb-3">
						<?php
						// Do WP_Loop if we get results
						while ( $loop->have_posts() ) :
							$loop->the_post();
							$imgurl = get_field( 'image' );

							if ( filter_var( $imgurl, FILTER_VALIDATE_URL ) === false ) {
								$imgurl = wp_get_attachment_url( $imgurl );
							}

							if ( get_field( 'utvalt_objekt' ) == true ) {
								?>
							<div class="card col-md mr-3" style="width: 20rem;">
								<img class="card-img-top" src="<?php echo $imgurl; ?>" alt="Card image cap">
								<div class="card-body">
									<h5 class="card-title"><?php echo get_the_title(); ?></h5>
									<h5 class="card-text"><?php echo get_field( 'Address' ); ?></h5>
									<p class="card-text"> <?php the_content(); ?></p>
									<a href="<?php echo get_the_permalink(); ?>" class="btn btn-primary">Gå till bostad</a>
								</div>
							</div>	
							<?php } ?>
					
							<?php endwhile; 
							wp_reset_postdata();
							?>
					</div>
					<h2>Övriga bostäder</h1>
					<div class="row mt-3">		
							<?php // Andra loopen för att skriva ut resten ` ?>
							<?php
							// Do WP_Loop if we get results
							while ( $loop->have_posts() ) :
								$loop->the_post();
								$imgurl = get_field( 'image' );

								if ( filter_var( $imgurl, FILTER_VALIDATE_URL ) === false ) {
									$imgurl = wp_get_attachment_url( $imgurl );
								}

								if ( get_field( 'utvalt_objekt' ) !== true ) {
									?>
							<div class="card col-md mr-3" style="width: 14rem;">
								<img class="card-img-top" src="<?php echo $imgurl; ?>" alt="Card image cap">
								<div class="card-body">
									<h5 class="card-title"><?php echo get_the_title(); ?></h5>
									<h5 class="card-text"><?php echo get_field( 'Address' ); ?></h5>
									<p class="card-text"> <?php the_content(); ?></p>
									<a href="<?php echo get_the_permalink(); ?>" class="btn btn-primary">Gå till bostad</a>
								</div>
							</div>
							<?php } ?>
								<?php endwhile; ?>
					</div>
							
							<?php
							wp_reset_postdata();
						endif;
						

			
					?>

					<?php else : ?>
					
						<?php get_template_part( 'loop-templates/content', 'none' ); ?>

					<?php endif; ?>

			</main><!-- #main -->


			<!-- The pagination component -->
			<?php
			understrap_pagination();
			?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

			</div><!-- .row -->
			
	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
