<?php

/**
 * Template Name: Home page
 * Template Post Type: page
 *
 * @package testdevvn
 */
?>

<?php get_header() ?>

<?php
do_action('wptestdev_text_intro');
?>

<div class="row">
    <?php
    $query = new WP_Query([
        'post_type' => 'services',
        'posts_per_page' => 5,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ]);
    if($query->have_posts()){

    while ($query->have_posts()) : $query->the_post(); ?>
        <?php require('parts/card.php'); ?>
    <?php endwhile;
    wp_reset_postdata();
    }
    
    ?>
</div>

    <?php the_content(); ?>

<?php get_footer() ?>