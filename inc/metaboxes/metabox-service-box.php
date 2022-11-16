<?php

class ServiceBoxSize
{
    const META_KEY = 'testdevwp_service_box';
    public static function register()
    {
        add_action('add_meta_boxes', [self::class, 'add']);
        add_action('save_post', [self::class, 'save']);
    }

    public static function add()
    {
        add_meta_box(self::META_KEY , 'The box is big ?', [self::class, 'render'], 'services', 'side');
    }

    public static function render($post_id)
    {
        $value = get_post_meta($post_id->ID, self::META_KEY, true);

        ?>
            <input type="checkbox" value="yes" name="<?= self::META_KEY ?>" id="testdevwprenderserviceboxbig" <?= $value === 'yes' ? 'checked' : '' ?>>
            <label for="testdevwprenderserviceboxbig">Yes</label>
        <?php
    }

    public static function save($post_id)
    {
        if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit'])) {
            return $post_id;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        if (!empty($_POST[self::META_KEY]) && $_POST[self::META_KEY] === 'yes') {
            update_post_meta($post_id, self::META_KEY, 'yes');
        } else {
            delete_post_meta($post_id, self::META_KEY );
        }
    }
}