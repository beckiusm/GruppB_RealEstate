<?php
$loop = new WP_Query(
	array(
		'cat'            => get_query_var( 'cat' ),
		'posts_per_page' => 1,
		'meta_key'       => 'utvalt_objekt',
		'meta_value'     => true,
	)
);
setlocale( LC_ALL, '' );
if ( $loop->have_posts() ) :
	?>
	<div class="row mb-3">
		<?php
		/* Do WP_Loop if we get results */
		while ( $loop->have_posts() ) :
			$loop->the_post();
			$time   = strtotime( get_field( 'visning' ) );
			$date   = strftime( '%e %B, %Y', $time );
			$imgid  = get_field( 'image' );
			$imgurl = wp_get_attachment_image_src( $imgid, 'large' )[0];
			?>
			<div class="card col-md p-0 mr-3">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>"><img class="cat-image" src="<?php echo esc_url( $imgurl ); ?>" alt="Card image cap"></a>
				<div class="card-body p-2">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<h5 class="card-title"><?php echo esc_html( get_the_title() ); ?></h5></a>
					<p class="card-text-address m-0"><?php echo esc_html( 'Adress: ' . get_field( 'address' ) ); ?></p>
					<p class="card-text-left m-0"><?php echo esc_html( 'BoArea: ' . get_field( 'boarea' ) ) . ' m² '; ?></p>
					<p class="card-text-right m-0"><?php echo esc_html( 'Rum: ' . get_field( 'rooms' ) ) . ' rum '; ?></p>
					<p class="card-text-right m-0"><?php echo esc_html( 'Visningsdatum: ' . $date ); ?></p>
					<p class="card-text-price-utvalt m-0"><?php echo esc_html( 'Utgångspris: ' . number_format( (float) get_field( 'utgangsbud' ), 0, ',', ' ' ) ) . ' kr '; ?></p>
				</div>
			</div>

		<?php endwhile; ?>
	</div>
	<?php
	wp_reset_postdata();
	endif;
?>
