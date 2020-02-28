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
			$imgid  = get_field( 'image' );
			$imgurl = wp_get_attachment_image_src( $imgid, 'medium' )[0];
			?>
			<div class="card col-md mr-3" style="width: 14rem;">
			<a href="<?php echo get_the_permalink(); ?>"><img class="card-img-top" src="<?php echo $imgurl; ?>" alt="Card image cap"></a>
				<div class="card-body">
				<a href="<?php echo get_the_permalink(); ?>">
					<h5 class="card-title"><?php echo get_the_title(); ?></h5></a>
					<p class="card-text">Adress : <?php echo get_field( 'address' ); ?></p>
				</div>
			</div>

		<?php endwhile; ?>
	</div>
	<?php endif; ?>
