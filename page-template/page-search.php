<?php

/**
 * Template Name: Search page
 * Template Post Type: page
 *
 * @package testdevvn
 */

get_header();
?>

<form class="form-inline my-2 mb-4" action="" method="GET">
    <label for="keyword">Recherche</label>
    <input class="form-control mr-sm-2 col-4" name="keyword" type="search" placeholder="Recherche..." aria-label="Search" value="<?= get_search_query() ?>">
    <button class="btn btn-outline my-2 my-sm-0 col-4" type="submit">Rechercher</button>
</form>

<div class="row d-flex justify-content-center">
    <?php 
    global $wp_query;
    $tmp = $wp_query;

    $current = get_query_var('paged') ? get_query_var('paged') : 1;

    $args = [
        'post_type' => 'services',
        'posts_per_page' => 4,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'paged' => $current, 
    ];

    if (!empty($_REQUEST['keyword'])) {
        $args['s'] = wp_strip_all_tags($_REQUEST['keyword']);
    }

    $wp_query = new WP_Query($args);

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
    } else {
        ?>
            <div class="col-12 col-md-8">
                <?php get_template_part('parts/content-none', 'none'); ?>
            </div>
    <?php }  
    ?>
    <nav aria-label="Pagination" class="my-4">
        <?= $pagination; ?>
    </nav>
</div>

<?php
get_footer();