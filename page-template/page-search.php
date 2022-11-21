<?php

/**
 * Template Name: Search page
 * Template Post Type: page
 *
 * @package testdevvn
 */

get_header();
get_search_form();
?>

<div class="row">
    <?php
    global $wp_query;
    $tmp = $wp_query;

    $current = get_query_var('paged') ? get_query_var('paged') : 1;

    $wp_query = new WP_Query([
        'post_type' => 'services',
        'posts_per_page' => 4,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'paged' => $current,
    ]);

    $pagination = '';

    if ($wp_query->have_posts()) {

        $big = 999999999;
        $pagination = paginate_links([
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'total' => $wp_query->max_num_pages,
            'current' => $current,
        ]);

        while ($wp_query->have_posts()) : $wp_query->the_post();
            get_template_part('parts/card', 'post',['is_search_service' => true]);
        endwhile;

        $wp_query = $tmp;
        wp_reset_postdata();
    }

    ?>

    <nav aria-label="Pagination" class="my-4">
        <?= $pagination; ?>
    </nav>
</div>

<?php
get_footer();
