<?php

$services = get_terms([
    'taxonomy' => 'services_types',
    'object_ids' => get_the_ID(),
    'orderby' => 'name',
    'order' => 'DESC',
]);

$implode = implode(', ', array_column($services, 'name'));
$col = 'col-6 col-xl-3';
$boxSizeChoice = get_post_meta(get_the_ID(), ServiceBoxSize::META_KEY, true);

if (!empty($boxSizeChoice)) {
    $col = 'col-6';
}

if ($args['is_search_service']) {
    $col = 'col-12';
    $boxSizeChoice = '';
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