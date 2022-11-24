<?php

/**
 * Template Name: Search page
 * Template Post Type: page
 *
 * @package testdevvn
 */

get_header();

global $wp_query;
$tmp = $wp_query;
$add_args = [];
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$services_types = '';
if (!empty($_REQUEST['services-types'])) {
    $services_types = $_REQUEST['services-types'];
} else {
    $services_types = get_query_var('services-types');
}

$services_types_args = '';
if (!empty($services_types)) {
    $services_slugs = explode('+', $services_types);
    $services_types = wp_strip_all_tags($services_types);
    $services_types_args = [
        'taxonomy' => 'services_types',
        'field' => 'slug',
        'terms' => $services_slugs,
    ];
}

$args = [
    'post_type' => 'services',
    'posts_per_page' => 4,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'paged' => $paged,
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
        <form action="<?= get_permalink($post->ID); ?>" method="POST">
            <div class="form-row mb-5">
                <div class="form-group col-4 d-flex flex-column">
                    <label for="keyword">Votre recherche</label>
                    <input class="form-control" name="keyword" type="search" placeholder="Recherche..." aria-label="Search" value="<?= get_search_query() ?>">
                </div>
                <div class="form-group col-4 d-flex flex-column">
                    <label for="services-types">Catégories</label>

                    <?php

                    $services_key_value_array = [];
                    if (!empty($services_slugs)) {
                        foreach ($services_slugs as $service_slug) {
                            $term = get_term_by('slug', $service_slug, 'services_types');
                            $services_key_value_array[] = ["slug" => $term->slug, "name" => esc_html($term->name)];
                        }
                    }
                    ?>

                    <input
                    type= 'text'
                    class= 'form-control'
                    name= 'services-types'
                    id= 'services-types'
                    data-default-values= '<?php if (!empty($services_key_value_array)) { echo wp_json_encode($services_key_value_array); } ?>'
                    >

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
        $base = str_replace($big, '%#%', esc_url(get_pagenum_link($big)));
        
        if (!empty($services_types) && !stripos($base, '/services-types/' . $services_types)) {
            $base = str_replace('page', 'services-types/' . $services_types . '/page', $base);
        }

        $pagination_args = [
            'base' => $base,
            'format' => '?paged=%#%',
            'total' => $wp_query->max_num_pages,
            'current' => $paged,
            'add_args' => $add_args,
        ];

        while ($wp_query->have_posts()) : $wp_query->the_post();
            get_template_part('parts/card', 'post', ['is_search_service' => true]);
        endwhile;

        echo paginate_links($pagination_args);
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
