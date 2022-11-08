<?php get_header() ?>

<h1><?= esc_html(get_queried_object()->name) ?></h1>
<p><?= esc_html(get_queried_object()->description) ?></p>


<?php if (have_posts()) : ?>
    <div class="row">
        <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part('parts/card', 'post'); ?>

        <?php endwhile ?>
    </div>
<?php else : ?>
    <h1>Pas d'articles</h1>
<?php endif; ?>
<?php get_footer() ?>