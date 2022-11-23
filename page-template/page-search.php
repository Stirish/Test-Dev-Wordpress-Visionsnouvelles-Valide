<?php

/**
 * Template Name: Search page
 * Template Post Type: page
 *
 * @package testdevvn
 */

get_header();

$terms = get_terms('services_types');

global $wp_query;
$tmp = $wp_query;

$current = get_query_var('paged') ? get_query_var('paged') : 1;

if (!empty($_REQUEST['services-types'])) {
    $services_types = $_REQUEST['services-types'];
} else {
    $services_types = get_query_var('services-types');
}

$services_types_args = '';
if (!empty($_REQUEST['services-types'])) {
    $services_types = wp_strip_all_tags($services_types);
    $services_types_args = [
        'taxonomy' => 'services_types',
        'field' => 'slug',
        'terms' => [$services_types],
    ];
}

$args = [
    'post_type' => 'services',
    'posts_per_page' => 4,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'paged' => $current,
    'tax_query' => [
        'relation' => 'AND',
        $services_types_args,
    ]
];

if (!empty($_REQUEST['keyword'])) {
    $args['s'] = wp_strip_all_tags($_REQUEST['keyword']);
    $add_args['keyword'] = $args['s'];
}

$wp_query = new WP_Query($args);

global $post;
?>
<div class="row">
    <div class="col-12">
        <form action="<?= get_permalink($post->ID); ?>" method="GET">
            <div class="form-row mb-5">
                <div class="form-group col-4 d-flex flex-column">
                    <label for="keyword">Votre recherche</label>
                    <input class="form-control" name="keyword" type="search" placeholder="Recherche..." aria-label="Search" value="<?= get_search_query() ?>">
                </div>
                <div class="form-group col-4 d-flex flex-column">
                    <label for="services-types">Catégories</label>
                    <select id="inputState" class="form-control" name="services-types">
                        <option value="">...</option>

                        <?php foreach ($terms as $term) {
                            echo '<option value=" ' . esc_html($term->slug) . ' ">' . apply_filters('the_title', $term->name) . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="form-group col-4 d-flex align-items-end">
                    <button class="search-btn" type="submit">Rechercher</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row d-flex justify-content-center">
    <?php

    $pagination = '';

    if ($wp_query->have_posts()) {

        $big = 999999999;
        $pagination = paginate_links([
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'total' => $wp_query->max_num_pages,
            'current' => $current,
        ]);

        while ($wp_query->have_posts()) : $wp_query->the_post();
            get_template_part('parts/card', 'post', ['is_search_service' => true]);
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
