<?php get_header() ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h1><?php the_title() ?></h1>

                <?php $services = get_terms([
                        'taxonomy' => 'services_types',
                        'object_ids' => get_the_ID(),
                ]); ?>

                <h2 class="card-subtitle mb-2 text-muted">Type:
                        <?php foreach ($services as $service) : ?>
                                <?= $service->name ?>
                        <?php endforeach; ?></h2>
                <?php the_post_thumbnail('single-services-img'); ?>
                <?php the_content() ?>
<?php endwhile;
endif; ?>

<?php get_footer() ?>