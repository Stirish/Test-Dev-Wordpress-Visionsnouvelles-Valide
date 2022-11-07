<?php

/**
 * Template Name: Home page
 * Template Post Type: page
 *
 * @package testdevvn
 */
?>

<?php get_header() ?>

<h1 class="homepage-tilte">Test by Visionsnouvelles</h1>
<p class="top-text">consectetur adipiscing elit. Nunc convallis sem eu scelerisque bibendum. Sed bibendum auctor libero porttitor dignissim. Curabitur id nisi
    <br />
    convallis, porta mauris vitae, ultricies nunc. Ut suscipit faucibus tempus. Aenean magna felis, sodales eleifend metus consectetur,
    <br />
    bibendum interdum nunc.
    <br /><br />
    <b>Cliquez sur le domaine qui vous correspond :</b>
</p>

<div class="row">
    <?php

    $query = new WP_Query([
        'post_type' => 'services',
        'posts_per_page' => 5,
    ]);

    while ($query->have_posts()) : $query->the_post(); ?>
        <?php require('parts/card.php'); ?>
    <?php endwhile; ?>
</div>

<figure class="bottom-text">
    <blockquote>
        <em>consectetur adipiscing elit. Nunc convallis sem eu scelerisque bibendum. Sed bibendum auctor libero porttitor
            <br />
            dignissim.</em> Curabitur id nisi convallis, porta mauris vitae, ultricies nunc. Ut suscipit faucibus tempus. Aenean magna
        <br />
        felis, sodales eleifend metus consectetur, bibendum interdum nunc. <b>Pierre qui roule n’amasse pas mousse.</b>
    </blockquote>
    <figcaption class="bottom-text--author">Alexis JUSKIWIESKI</figcaption>
</figure>

<?php get_footer() ?>