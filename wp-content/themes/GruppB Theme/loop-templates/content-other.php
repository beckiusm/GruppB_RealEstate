<?php

$loop_other = new WP_Query(
	array(
		'post_type'      => 'property',
		'posts_per_page' => 5,
		'paged'          => $paged,
	)
);
?>
<div class="row">
	<ul class="list-group">
		<?php
		// Do WP_Loop if we get results
		while ($loop_other->have_posts()) :
			$loop_other->the_post();
			$imgid  = get_field('image');
			$imgurl = wp_get_attachment_image_src($imgid, 'medium')[0];
		?>

			<li class="list-group-item border-0">
				<div class="card flex-row flex-wrap col-md-13 mt-3 p-3">
					<div class="card-header">
						<a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo $imgurl; ?>" alt="Image of property"></a>
					</div>
					<div class="card-block px-2">
						<a href="<?php echo get_the_permalink(); ?>">
							<h4 class="card-title"><?php echo get_the_title(); ?></h4>
						</a>
						<p class="card-text">Adress : <?php echo get_field('address'); ?></p>
						<p class="card-text">Utgångsbud : <?php echo get_field('utgangsbud') . ' kr '; ?></p>
						<p class="card-text">BoArea : <?php echo get_field('boarea') . 'm2 '; ?></p>
						<p class="card-text">Antal rum : <?php echo get_field('rooms') . ' rum '; ?></p>
					</div>
				</div>
			</li>
		<?php endwhile; ?>
	</ul>
</div>