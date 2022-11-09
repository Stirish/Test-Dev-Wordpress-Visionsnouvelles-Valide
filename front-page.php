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
     global $post;
    $query = new WP_Query([
        'post_type' => 'services',
        'posts_per_page' => 5,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ]);

    while ($query->have_posts()) : $query->the_post(); ?>
        <?php require('parts/card.php'); ?>
    <?php endwhile; ?>
</div>

<figure class="bottom-text">
    <?= the_field('citation')?>
    <figcaption class="bottom-text--author">
  
    </figcaption>
</figure>

<?php get_footer() ?>