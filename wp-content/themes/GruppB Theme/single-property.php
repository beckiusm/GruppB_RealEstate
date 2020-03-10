<?php
/*
* Template Name: Propery
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<h1 class="display-4"> <?php esc_html( the_title() ); ?> </h1>
					<?php
					$images  = acf_photo_gallery( 'image', $post->ID );
					$counter = 0;
					if ( count( $images ) ) :
						?>
						<!--Loop out images -->
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<?php
								foreach ( $images as $image ) {
									if ( $counter === 0 ) {
										?>
										<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo esc_html( $counter ); ?>" class="active"></li>
									<?php } else { ?>
										<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo esc_html( $counter ); ?>"></li>
										<?php
									}
									$counter++;
								}
								?>
							</ol>
							<div class="carousel-inner">
								<?php
								$counter = 0;
								foreach ( $images as $image ) :
									$id             = $image['id']; // The attachment id of the media
									$full_image_url = $image['full_image_url']; // Full size image url
									$url            = $image['url']; // Goto any link when clicked
									$title          = $image['title'];
									?>
									<?php if ( $counter === 0 ) { ?>
										<div class="carousel-item active">
											<img class="d-block w-100" src="<?php echo esc_html( $full_image_url ); ?>" alt="<?php echo esc_html( $title ); ?>" title="<?php echo $title; ?>">
										</div>
										<?php
									} else {
										?>
										<div class="carousel-item">
											<img class="d-block w-100" src="<?php echo esc_html( $full_image_url ); ?>" alt="<?php echo esc_html( $title ); ?>" title="<?php echo $title; ?>">
										</div>
										<?php
									}
									$counter++;
								endforeach;
								?>
							</div>
							<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
						<?php
					endif;
					?>
					<div class="row mb-3 mt-3">
						<div class="property-p col-md-9"> <?php echo esc_html( the_content() ); ?> </div>
						<ul class="list-group col-md-3">
							<li class="list-group-item py-0"><span class="bold-item">Adress:</span> <?php echo esc_html( get_field( 'address' ) ); ?></li>
							<li class="list-group-item py-0"><span class="bold-item">Ort:</span> <?php echo esc_html( get_field( 'ort' ) ); ?></li>
							<li class="list-group-item py-0"><span class="bold-item">Visningsdatum:</span> <?php echo esc_html( get_field( 'visning' ) ); ?></li>
							<li class="list-group-item py-0"><span class="bold-item">Antal rum:</span> <?php echo esc_html( get_field( 'rooms' ) ); ?> </li>
							<li class="list-group-item py-0"><span class="bold-item">Boarea:</span> <?php echo esc_html( get_field( 'boarea' ) . ' m2' ); ?> </li>
							<li class="list-group-item py-0"><span class="bold-item">Utgångsbud:</span> <?php echo esc_html( number_format( (float) get_field( 'utgangsbud' ), 0, ',', ' ' ) ) . ' kr '; ?></li>
						</ul>
					</div>
					
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

					<?php
				endwhile; // end of the loop.
				?>

			</main><!-- #main -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>
