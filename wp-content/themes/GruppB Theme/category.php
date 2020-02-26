<?php

/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('understrap_container_type');
?>

<div class="wrapper" id="archive-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php get_template_part('global-templates/left-sidebar-check'); ?>

            <main class="site-main" id="main">
                <?php
                global $wp;
                $url = home_url($wp->request);

                $category = substr($url, strpos($url, "category") + 9);
                echo  "current cat: " . $category . "<br>";

                $args = array(
                    'post_type' => 'property',
                    'posts_per_page' => -1,
                    'category' => $category,
                   
                );
                $loop = new WP_Query($args);
                //var_dump($loop);
                if ($loop->have_posts()) :
                   
                        while ($loop->have_posts()) :
                            $loop->the_post();
                            echo "Titel av post" . get_the_title() . "<br>";

                        endwhile;
                    endif;
                    wp_reset_postdata();
                    if (have_posts()) : ?>

                        <header class="page-header">
                            <?php
                            the_archive_title('<h1 class="page-title">', '</h1>');
                            the_archive_description('<div class="taxonomy-description">', '</div>');
                            ?>
                        </header><!-- .page-header -->

                        <?php /* Start the Loop */



                        foreach ($decoded as $todo) {
                            $args = [
                                "post_type" => "property",
                                "meta_key" => "remote_id",
                                "meta_value" => $todo->id
                            ];
                            $query = new WP_Query($args);
                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $postid = get_the_ID();
                                    updatePost($postid, $todo->title, $todo->id, $todo->userId, $todo->completed);
                                }
                            } else {
                                newPost($todo->title, $todo->id, $todo->userId, $todo->completed);
                            }
                        }
                        $query = new WP_Query($args);
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                $postid = get_the_ID();
                                updatePost($postid, "hohoho", 43, 1, true);
                            }
                        } else {
                            newPost("Hejsan", 43, 1, false);
                        }
                        wp_reset_query();

                    else : ?>

                        <?php get_template_part('loop-templates/content', 'none'); ?>

                    <?php endif; ?>

            </main><!-- #main -->

            <!-- The pagination component -->
            <?php understrap_pagination(); ?>

            <!-- Do the right sidebar check -->
            <?php get_template_part('global-templates/right-sidebar-check'); ?>

        </div> <!-- .row -->

    </div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php get_footer(); ?>