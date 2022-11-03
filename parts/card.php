<?php $services = get_terms([
    'taxonomy' => 'services_types',
    'object_ids' => get_the_ID(),
]); ?>



<a href="<?php the_permalink() ?>" class="card">
    <div class="card-body">
        <h2 class="card-title"><?php the_title() ?></h2>
        <h3 class="card-subtitle mb-2">Type :
            <?php foreach ($services as $service) : ?>
                <?= $service->name ?>
            <?php endforeach; ?></h3>
    </div>
</a>