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
				<h1>Utvalda bostäder</h1>
				<?php if ( have_posts() ) : ?>

					<?php
					// Prepare query
					$paged       = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$loop_utvalt = new WP_Query(
						array(
							'post_type'      => 'property',
							'posts_per_page' => 3,
							'meta_key'       => 'utvalt_objekt',
							'meta_value'     => true,
						)
					);

					$loop_other = new WP_Query(
						array(
							'post_type'      => 'property',
							'posts_per_page' => 5,
							'paged'          => $paged,
						)
					);

					if ( $loop_utvalt->have_posts() ) :
						?>
					<div class="row mb-3">
						<?php
						// Do WP_Loop if we get results
						while ( $loop_utvalt->have_posts() ) :
							$loop_utvalt->the_post();
							$imgurl = get_field( 'image' );
							if ( filter_var( $imgurl, FILTER_VALIDATE_URL ) === false ) {
								$imgurl = wp_get_attachment_url( $imgurl );
							}
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

						<?php endwhile; ?>
					</div>
					<h2>Övriga bostäder</h1>
					<div class="row">
						<?php
						// Do WP_Loop if we get results
						while ( $loop_other->have_posts() ) :
							$loop_other->the_post();
							$imgurl = get_field( 'image' );
							if ( filter_var( $imgurl, FILTER_VALIDATE_URL ) === false ) {
								$imgurl = wp_get_attachment_url( $imgurl );
							}
							?>
						<div class="card flex-row flex-wrap col-md-12 mt-3 p-2">
							<div class="card-header">
								<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $imgurl; ?>" alt="Image of property" style="width: 300px;"></a>
							</div>
							<div class="card-block px-2">
								<a href="<?php echo get_the_permalink(); ?>"><h4 class="card-title"><?php echo get_the_title(); ?></h4></a>
								<p class="card-text">Adress : <?php echo get_field( 'Address' ); ?></p>
								<p class="card-text">Utgångsbud : <?php echo get_field( 'utgangsbud' ) . ' kr '; ?></p>
								<p class="card-text">BoArea : <?php echo get_field( 'boarea' ) . 'm2 '; ?></p>
								<p class="card-text">Antal rum : <?php echo get_field( 'rooms' ) . ' rum '; ?></p>
							</div>
						</div>
							<?php endwhile; ?>
					</div>
							<?php
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
		</div>
			<!-- Do the right sidebar check -->
						<?php get_template_part( 'sidebar-templates/sidebar-primary', 'right' ); ?>

			</div><!-- .row -->
			
	</div><!-- #content -->

</div><!-- #index-wrapper -->

						<?php get_footer(); ?>
