<?php

class ServicePrice
{
    const META_KEY = 'testdevwp_service_price';
    public static function register()
    {
        add_action('add_meta_boxes', [self::class, 'add']);
        add_action('save_post', [self::class, 'save']);
    }

    public static function add()
    {
        add_meta_box(self::META_KEY, 'service price ?', [self::class, 'render'], 'services', 'side');
    }

    public static function render($post_id)
    {
        $value = get_post_meta($post_id->ID, self::META_KEY, true);

        ?>
            <form>
                <label>
                    <input type="number" value="<?= $value ?>" name="<?= self::META_KEY ?>">
                </label>
            </form>
        <?php
    }

    public static function save($post_id)
    {
        $input = $_POST[self::META_KEY];

        if (!empty($input)) {
            update_post_meta($post_id, self::META_KEY, $input);
        } else {
            delete_post_meta($post_id, self::META_KEY);
        }
    }
}