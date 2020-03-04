<?php
$loop = new WP_Query(
	array(
		'cat'			 => get_query_var( 'cat' ),
		'posts_per_page' => 1,
		'meta_key'       => 'utvalt_objekt',
		'meta_value'     => true,
	)
);
if ( $loop->have_posts() ) :
	?>
	<div class="row mb-3">
		<?php
		/* Do WP_Loop if we get results? */
		while ($loop->have_posts() ) :
			$loop->the_post();
			$imgid  = get_field( 'image' );
			$imgurl = wp_get_attachment_image_src( $imgid, 'large' )[0];
			?>
			<div class="card col-md p-0 mr-3">
				<a href="<?php echo esc_html( get_the_permalink() ); ?>"><img class="cat-image" src="<?php echo esc_html( $imgurl ); ?>" alt="Card image cap"></a>
				<div class="card-body">
					<a href="<?php echo esc_html( get_the_permalink() ); ?>">
						<h5 class="card-title"><?php echo esc_html( get_the_title() ); ?></h5>
					</a>
					<p class="card-text">Adress : <?php echo esc_html( get_field( 'address' ) ); ?>
					<p class="card-text">Pris : <?php echo esc_html( get_field( 'utgangspris' ) ) . ' kr'; ?>
					<p class="card-text">BoArea : <?php echo esc_html( get_field( 'boarea' ) ) . 'm2' ; ?>
					<p class="card-text">Adress : <?php echo esc_html( get_field( 'address' ) ); ?>
					<p class="card-text">Visningsdatum : <?php echo esc_html( get_field( 'visning' ) ); ?>
				</p>
				</div>
			</div>

		<?php endwhile; ?>
	</div>
	<?php
	wp_reset_postdata();
	endif;
	?>