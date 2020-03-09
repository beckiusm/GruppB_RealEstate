<?php
/**
 * The template for displaying search forms
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<form method="get" class="col-md-3 mb-3" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label class="sr-only" for="s"><?php esc_html_e( 'Search', 'understrap' ); ?></label>
	<div class="form-group">
		<input class="field form-control" id="s" name="s" type="text"
			placeholder="<?php esc_attr_e( 'Sök&hellip;', 'understrap' ); ?>" value="<?php the_search_query(); ?>">
	</div>
	<div class="form-group">
		<select name="category_name" class="form-control">
		<?php
		echo '<option value="">Välj kategori</option>';
		// generate list of categories
		$categories = get_categories();
		foreach ( $categories as $category ) {
			echo '<option value="', $category->slug, '">', $category->name, "</option>\n";
		}
		?>
		</select>
	</div>
	
	<?php
	// generate list of tags
	$tags = get_tags();
	foreach ( $tags as $tag ) {
		echo '<div class="form-check-inline">';
		echo '<input id="' . $tag->slug . '" type="checkbox" class="form-check-input" name="taglist[]" value="' . $tag->slug . '" />'; //before it was name="taglist[]"
		echo '<label for="' . $tag->slug . '" class="form-check-label">' . ucfirst($tag->name) . "</label></div>";
	}
	?>
	<div class="form-group mt-2">
		<label for="min_room">Min rum</label>
		<input class="form-control" type="text" name="min_room" id="min_room" placeholder="Min rum">
		<label for="max_room">Max rum</label>
		<input class="form-control" type="text" name="max_room" id="max_room" placeholder="Max rum">
		<label for="min_price">Min pris</label>
		<input class="form-control" type="text" name="min_price" id="min_price" placeholder="Min pris">
		<label for="max price">Max pris</label>
		<input class="form-control" type="text" name="max_price" id="max_price" placeholder="Max pris">
	</div>
	<input class="submit btn btn-primary" id="searchsubmit" name="submit" type="submit"
	value="<?php esc_attr_e( 'Sök', 'understrap' ); ?>">
</form>
