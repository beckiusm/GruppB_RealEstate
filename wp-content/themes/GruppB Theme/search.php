<?php
//Detta printar ut resultatet när man har sökt

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper container-fluid" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md content-area" id="primary">

				<main class="site-main content" id="main">
					<h1>Sökresultat</h1>

					<?php
						
						$categoryName = $_GET["category_name"];
						$tagName = $_GET["tagName"];

						echo "the category: " . $categoryName . " the tag: " . $tagName;
						// echo "the tag: " . $tagName;

						$args = array(
							'tag' => $tagName,
							'category_name' => $categoryName
						);
							
						$the_query = new WP_Query( $args );

						include( locate_template( 'loop-templates/content-search.php', false, false ) ); //för att kunna använda mig av varibeln the_query i templaten

						// $categoryName = $_GET["category_name"];
						// $tagName = $_GET["tagName"];

						// if ( $categoryName === "" && $tagName ) {

						// 	echo "the tag: " . $tagName;
							
						// 	$the_query = new WP_Query( 'tag=' . $_GET["tagName"] );

						// 	include( locate_template( 'loop-templates/content-search.php', false, false ) ); //för att kunna använda mig av varibeln the_query i templaten

						// } elseif ($categoryName && !($tagName)) {
						// 	echo "the category: " . $categoryName;
						// 	$the_query = new WP_Query( 'category_name=' . $categoryName );
						// 	include( locate_template( 'loop-templates/content-search.php', false, false ) );
						// } else {
						// 	echo "du måste fylla i antingen kategori eller tagg. I framtiden ska alla objekten listas här";
						// }

					?>
				</main><!-- #main -->
			</div>
			<!-- Do the right sidebar check -->
			<?php get_search_form(); //get_template_part( 'sidebar-templates/sidebar-primary', 'right' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
