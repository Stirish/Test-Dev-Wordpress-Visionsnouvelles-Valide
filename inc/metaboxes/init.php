<?php

if (!defined('ABSPATH')) {
    exit();
}

require get_template_directory() . '/inc/metaboxes/metabox-service-box.php';
ServiceBoxSize::register();

require get_template_directory() . '/inc/metaboxes/metabox-service-price.php';
ServicePrice::register();

require get_template_directory() . '/inc/metaboxes/metabox-taxonomy-header-color.php';
HeaderColor::register();