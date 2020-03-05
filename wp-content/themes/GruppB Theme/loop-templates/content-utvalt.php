<?php
	// Prepare query
	$loop = new WP_Query(
		array(
			'post_type'      => 'property',
			'posts_per_page' => 3,
			'meta_key'       => 'utvalt_objekt',
			'meta_value'     => true,
		)
	);
	if ( $loop->have_posts() ) :
		?>
	<div class="row mb-3">
		<?php
		while ( $loop->have_posts() ) :
			$loop->the_post();
			$imgid  = get_field( 'image' );
			$imgurl = wp_get_attachment_image_src( $imgid, 'medium' )[0];
			?>
			<div class="card col-md p-0 mr-3">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>"><img class="card-img-top" src="<?php echo esc_url( $imgurl ); ?>" alt="Card image cap"></a>
				<div class="card-body p-2">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<h5 class="card-title"><?php echo esc_html( get_the_title() ); ?></h5></a>
					<p class="card-text-address m-0"><?php echo esc_html( get_field( 'address' ) ); ?></p>
					<p class="card-text-left m-0"><?php echo esc_html( get_field( 'boarea' ) ) . ' m² '; ?></p>
					<p class="card-text-right m-0"><?php echo esc_html( get_field( 'rooms' ) ) . ' rum '; ?></p>
					<p class="card-text-price-utvalt m-0"><?php echo esc_html( number_format( (float) get_field( 'utgangsbud' ), 0, ',', ' ' ) ) . ' kr '; ?></p>
				</div>
			</div>
			<?php
		endwhile;
		?>
	</div>
		<?php
		wp_reset_postdata();
		endif;
	?>
