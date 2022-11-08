<?php get_header('') ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <?php

        $services = get_terms([
            'taxonomy' => 'services_types',
            'object_ids' => get_the_ID(),
        ]);

        $prices = get_post_meta(get_the_ID(), 'testdevwp_service_price', true);

        ?>

        <div class="service-title row">
            <div class="col-12">
                <h1><?php the_title() ?></h1>
            </div>
        </div>

        <div class="service-type row">
            <div class="col-12 mb-4">
                <span>Type : </span>
                <?php foreach ($services as $service) : ?>
                    <a href="<?= get_term_link($service) ?>">
                        <?= $service->name ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class=" service-article row">
            <div class="col-12 col-lg-4">
                <?php the_post_thumbnail('single-services-img', ['class' => 'img-fluid mb-5']); ?>
                <div class="service-price">
                    <span>Prix du service : </span>
                    <b><?= $prices ?>€</b>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <?php the_content() ?>
            </div>
        </div>

<?php endwhile;
endif; ?>

<?php get_footer() ?>