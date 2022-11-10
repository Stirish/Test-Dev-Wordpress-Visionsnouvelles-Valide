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
            $services = get_terms([
                'taxonomy' => 'services_types',
                'object_ids' => get_the_ID(),
                'orderby' => 'name',
                'order' => 'DESC',
            ]);

            $implode = implode(', ', array_column($services, 'name'));
            $col = 'col-6 col-xl-3';
            $boxSizeChoice = get_post_meta(get_the_ID(), 'testdevwp_service_box', true);

            if (!empty($boxSizeChoice)) {
                $col = 'col-6';
            }
    ?>
            <div class="container-card <?= $col ?>">
                <div>
                    <a href="<?php the_permalink() ?>" class="card">
                        <div class="card-body">
                            <h2 class="card-title"><?php the_title() ?></h2>
                            <h3 class="card-subtitle mb-2">Type :
                                <?= $implode ?></h3>
                        </div>
                    </a>
                </div>
            </div>
    <?php endwhile;
        wp_reset_postdata();
    }

    ?>
</div>

<?php
the_content();
get_footer();
?>