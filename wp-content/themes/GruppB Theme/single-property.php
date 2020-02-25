<?php
/*
* Template Name: Propery
*/

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container = get_theme_mod('understrap_container_type');
?>

<div class="wrapper" id="single-wrapper">

    <div class="<?= esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php get_template_part('global-templates/left-sidebar-check'); ?>

            <main class="site-main" id="main">

                <?php while (have_posts()) : the_post(); ?>
                    <h1 class="display-4"> <?php the_title(); ?> </h1>
                    <?php
                    $images = acf_photo_gallery('image', $post->ID);
                    $counter = 0;
                    if (count($images)) :
                    ?>
                        <!--Loop out images -->
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                foreach ($images as $image) :
                                    $id = $image['id']; // The attachment id of the media
                                    $full_image_url = $image['full_image_url']; //Full size image url
                                    $url = $image['url']; //Goto any link when clicked
                                    $title = $image["title"];
                                ?>
                                    <?php if ($counter === 0) { ?>
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src="<?= $full_image_url; ?>" alt="<?= $title; ?>" title="<?= $title; ?>">
                                        </div>
                                    <?php
                                    } else { ?>
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="<?= $full_image_url; ?>" alt="<?= $title; ?>" title="<?= $title; ?>">
                                        </div>
                                <?php }
                                    $counter++;
                                endforeach;
                                ?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    <?php
                    endif; ?>
                    <p class="property-p"> <?php the_content(); ?> </p>
                    <ul class="list-group">
                        <li class="list-group-item">Adress : <?= get_field('Address') ?></li>
                        <li class="list-group-item">Visningsdatum <?= get_field('visning') ?></li>
                        <li class="list-group-item">Antal Rum: <?= get_field('rooms') ?> </li>
                        <li class="list-group-item">Boarea: <?= get_field('boarea') ?> </li>
                        <li class="list-group-item">Utgångsbud: <?= get_field('utgangsbud') ?></li>
                    </ul>
                    <?php var_dump(get_field('utvalt_objekt')); ?>
                    <?php if (get_field('utvalt_objekt') == true) {
                        echo "print this objekt";
                    } else {
                        echo "dont print this objekt";
                    } ?>
                    <?php the_field('utvalt_objekt'); ?>
                    <?php //understrap_post_nav(); 
                    ?>

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; // end of the loop. 
                ?>

            </main><!-- #main -->

            <!-- Do the right sidebar check -->
            <?php get_template_part('global-templates/right-sidebar-check'); ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>