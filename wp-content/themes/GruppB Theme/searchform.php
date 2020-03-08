<?php
/**
 * The template for displaying search forms
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<form method="get" class="col-md-3" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label class="sr-only" for="s"><?php esc_html_e( 'Search', 'understrap' ); ?></label>
	<div class="form-group">
		<input class="field form-control" id="s" name="s" type="text"
			placeholder="<?php esc_attr_e( 'Search &hellip;', 'understrap' ); ?>" value="<?php the_search_query(); ?>">
	</div>
	<div class="form-group">
		<select name="category_name" class="form-control">
		<?php
		echo '<option value="">välj kategori</option>';
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
		echo '<div class="form-check">';
		echo '<input id="' . $tag->slug . '" type="checkbox" class="form-check-input" name="tagName" value="' . $tag->slug . '" />'; //before it was name="taglist[]"
		echo '<label for="' . $tag->slug . '" class="form-check-label">' . ucfirst($tag->name) . "</label></div>";
	}
	?>
	<input class="submit btn btn-primary" id="searchsubmit" name="submit" type="submit"
	value="<?php esc_attr_e( 'Search', 'understrap' ); ?>">
</form>
