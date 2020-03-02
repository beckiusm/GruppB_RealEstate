<?php
	// Prepare query
	$loop = new WP_Query(
		array(
            'cat' => get_query_var('cat'),
            'posts_per_page' => 1,
			'meta_key'       => 'utvalt_objekt',
			'meta_value'     => true,
		)
	);
	if ( $loop->have_posts() ) :
		?>
	<div class="row mb-3">
		<?php
		// Do WP_Loop if we get results
		while ( $loop->have_posts() ) :
			$loop->the_post();
			$imgid  = get_field( 'image' );
			$imgurl = wp_get_attachment_image_src( $imgid, 'medium' )[0];
			?>
			<div class="card col-md p-0 mr-3">
			<a href="<?php echo get_the_permalink(); ?>"><img class="card-img-top" src="<?php echo $imgurl; ?>" alt="Card image cap"></a>
				<div class="card-body">
				<a href="<?php echo get_the_permalink(); ?>">
					<h5 class="card-title"><?php echo get_the_title(); ?></h5></a>
					<p class="card-text">Adress : <?php echo get_field( 'address' ); ?></p>
				</div>
			</div>

		<?php endwhile; ?>
	</div>
		<?php
		wp_reset_postdata();
endif; ?>
