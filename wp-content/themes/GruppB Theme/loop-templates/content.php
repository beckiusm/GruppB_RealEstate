<div class="row mt-3">
	<?php
	// Do WP_Loop if we get results
	while ( have_posts() ) :
		the_post();
		$imgid  = get_field( 'image' );
		$imgurl = wp_get_attachment_image_src( $imgid, 'medium' )[0];
		?>
		<div class="card flex-row flex-wrap col-md-12 p-0 mb-3">
			<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $imgurl; ?>" alt="Image of property"></a>
			<div class="card-block p-2">
				<a href="<?php echo get_the_permalink(); ?>">
					<h4 class="card-title"><?php echo get_the_title(); ?></h4>
				</a>
				<p class="card-text">Adress : <?php echo get_field( 'address' ); ?></p>
				<p class="card-text">Utgångsbud : <?php echo get_field( 'utgangsbud' ) . ' kr '; ?></p>
				<p class="card-text">BoArea : <?php echo get_field( 'boarea' ) . 'm2 '; ?></p>
				<p class="card-text">Antal rum : <?php echo get_field( 'rooms' ) . ' rum '; ?></p>
			</div>
		</div>
    <?php endwhile; ?>
    <?php understrap_pagination(); 
    wp_reset_postdata();
    ?>
</div>
