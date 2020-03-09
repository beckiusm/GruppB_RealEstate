<div class="row mt-3">
	<?php
	// Do WP_Loop if we get results
	get_search_query();

	if ( ! ( have_posts() ) ) :
		?>
		<div class="col-md-12 p-0 mb-3">
		<img src="http://localhost/gruppb_realestate/wp-content/uploads/2020/03/search-sad.png" alt="Image of failed search">
			<p>Tyvärr så hittade vi inte vad du sökte på! Men nedan är några förslag ifrån oss: </p>
			<?php
			$tags_search = array_slice( get_tags(), 0, 10 );
			$counter     = count( $tags_search );
			foreach ( $tags_search as $tag_search ) :
				$comma = ( $counter > 1 ) ? ', ' : '';
				echo '<span class="card-tag"><a href="' . esc_url( get_tag_link( $tag_search->term_id ) ) . '">' . esc_html( strtolower( $tag_search->name ) ) . '</a>' . esc_html( $comma ) . '</span>';
				$counter--;
			endforeach
			?>
			
		</div>
		<?php
	else :
		while ( have_posts() ) :
			the_post();
			$imgid  = get_field( 'image' );
			$imgurl = wp_get_attachment_image_src( $imgid, 'medium' )[0];
			?>
	
			<div class="card flex-row flex-wrap col-md-12 p-0 mb-3">
				<a class="loop-image-a" href="<?php echo esc_url( get_the_permalink() ); ?>"><img class="loop-image" src="<?php echo esc_url( $imgurl ); ?>" alt="Image of property"></a>
				<div class="card-block px-2 pt-2">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
						<h4 class="card-title mb-1"><?php echo esc_html( get_field( 'address' ) ); ?></h4>
					</a>
					<div class="card-categories mb-2">
					<?php
					if ( has_category() ) {
						$categories  = get_the_category();
						$counter_cat = count( $categories );
						foreach ( $categories as $category ) {
							$comma = ( $counter_cat > 1 ) ? ', ' : '';
							echo '<span class="card-category"><a href="' . esc_url( get_tag_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>' . esc_html( $comma ) . ' - ' . esc_html( get_field( 'ort' ) ) . '</span>';
							$counter_cat--;
						}
					}
					?>
					</div>
					<!--<p class="card-text-address m-0"><?php echo esc_html( get_field( 'address' ) ); ?></p>-->
					<p class="card-text-area m-0"><?php echo esc_html( get_field( 'boarea' ) ) . ' m² '; ?></p>
					<p class="card-text-rooms m-0"><?php echo esc_html( get_field( 'rooms' ) ) . ' rum '; ?></p>
					<p class="card-text-price mt-2 mb-0"><?php echo esc_html( number_format( (float) get_field( 'utgangsbud' ), 0, ',', ' ' ) ) . ' kr '; ?></p>
					<!--<p class="card-text-visning m-0"><?php echo esc_html( get_field( 'visning' ) ); ?></p>-->
					<div class="card-tags">
					<?php
					if ( has_tag() ) {
						$tags_card = get_the_tags();
						$counter   = count( $tags_card );
						foreach ( $tags_card as $tag_card ) {
							$comma = ( $counter > 1 ) ? ', ' : '';
							echo '<span class="card-tag"><a href="' . esc_url( get_tag_link( $tag_card->term_id ) ) . '">' . esc_html( $tag_card->name ) . '</a>' . esc_html( $comma ) . '</span>';
							$counter--;
						}
					}
					?>
					</div>
				</div>
			</div>
			<?php
		endwhile;
	endif;
	wp_reset_postdata();
	understrap_pagination();
	?>
</div>
