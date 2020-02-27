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
	<?php endif; ?>
