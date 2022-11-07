<?php get_header('') ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h1 class="service-title"><?php the_title() ?></h1>

                <?php $services = get_terms([
                        'taxonomy' => 'services_types',
                        'object_ids' => get_the_ID(),
                ]); ?>

                
                <div class="service-type"> 
                        <span>Type : </span>
                        <?php foreach ($services as $service) : ?>
                        <a href="<?= get_term_link($service)?>">        
                                <?= $service->name ?></a>
                        <?php endforeach; ?>
                </div>
                <div class="service-article">
                        <?php the_post_thumbnail('single-services-img'); ?>
                        
                        <?php the_content() ?>
                </div>

<?php endwhile;
endif; ?>

<?php get_footer() ?>