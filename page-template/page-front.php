<?php

/**
 * Template Name: Home page
 * Template Post Type: page
 *
 * @package testdevvn
 */

get_header();
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

    if ($query->have_posts()) {

        while ($query->have_posts()) : $query->the_post();
            get_template_part('parts/card', 'post'); 
        endwhile;
        wp_reset_postdata();
    }
    ?>

</div>
<a href="<?php echo vn_get_permalink_by_page_template('page-template/page-search.php')?>" class="form-btn">Voir tout les service</a>
<?php
the_content();
get_footer();
?>