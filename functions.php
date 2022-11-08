<?php

function testdevwp_supports()
{
   add_theme_support('title-tag');
   add_theme_support('post-thumbnails');

   add_image_size('single-services-img', 350, 350, true);
}

function testdevwp_register_assets()
{

   wp_register_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', []);
   wp_register_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', ['popper', 'jquery'], false, true);
   wp_register_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', [], false, true);
   wp_deregister_script('jquery');
   wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', [], false, true);
   wp_enqueue_style('bootstrap');
   wp_enqueue_script('bootstrap');

   wp_enqueue_style('testdevwp-style', get_stylesheet_uri(), [], 1.0);
   wp_enqueue_style('testdevwp-bundle', get_template_directory_uri() . '/style.css', array(), 1.0);
}

function testdevwp_init()
{
   register_post_type('services', [
      'label' => 'Services',
      'public' => true,
      'menu_position' => 3,
      //'menu_icon' => '',
      'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
      'show_in_rest' => true,
      'has_archive' => true,
   ]);

   register_taxonomy('services_types', 'services', [
      'labels' => [
         'name' => 'Services types',
         'singular_name'     => 'Service type',
         'plural_name'       => 'Services types',
         'search_items'      => 'Rechercher des services types',
         'all_items'         => 'Tous les services types',
         'edit_item'         => 'Editer le service type',
         'update_item'       => 'Mettre à jour le service type',
         'add_new_item'      => 'Ajouter un nouveau service type',
         'new_item_name'     => 'Ajouter un nouveau service type',
         'menu_name'         => 'Service type',
      ],
      'show_in_rest' => true,
      'hierarchical' => true,
      'show_admin_column' => true,
   ]);
}

// -------------------------------------------Service box

function testdevwp_add_custom_service_box()
{
   add_meta_box('testdevwp_service_box', 'The box is big ?', 'testdevwp_render_service_box', 'services', 'side');
}

function testdevwp_render_service_box($post_id)
{
   $value = get_post_meta($post_id->ID, 'testdevwp_service_box', true);

?>
   <input type="checkbox" value="yes" name="testdevwp_service_box" id="testdevwprenderserviceboxbig" <?= $value === 'yes' ? 'checked' : '' ?>>
   <label for="testdevwprenderserviceboxbig">Yes</label>
<?php
}

function testdevwp_save_service_box($post_id)
{
   // Enregistrement des données dans la base Wordpress.
   // évite de perdre des données à cause de l'enregistrement automatique
   if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit'])) {
      return $post_id;
   }
   // Vérification des droits de l'utilisateur.
   if (!current_user_can('edit_post', $post_id)) {
      return $post_id;
   }

   if (!empty($_POST['testdevwp_service_box']) && $_POST['testdevwp_service_box'] === 'yes') {
      update_post_meta($post_id, 'testdevwp_service_box', 'yes');
   } else {
      delete_post_meta($post_id, 'testdevwp_service_box');
   }
}


// -------------------------------------------Service price

function testdevwp_add_custom_service_price()
{
   add_meta_box('testdevwp_service_price', 'service price ?', 'testdevwp_render_service_price', 'services', 'side');
}

function testdevwp_render_service_price($post)
{
   $value = get_post_meta($post->ID, 'testdevwp_service_price', true);
?>
   <form>
      <label>
         <input type="number" value="<?= $value ?>" name="testdevwp_service_price">
      </label>
   </form>

<?php
}

function testdevwp_save_service_price($post_id)
{

   $input = $_POST['testdevwp_service_price'];

   if (!empty($input)) {
      update_post_meta($post_id, 'testdevwp_service_price', $input);
   } else {
      delete_post_meta($post_id, 'testdevwp_service_price');
   }
}

add_action('init', 'testdevwp_init');
add_action('after_setup_theme', 'testdevwp_supports');
add_action('wp_enqueue_scripts', 'testdevwp_register_assets');

// META BOX
add_action('add_meta_boxes', 'testdevwp_add_custom_service_box');
add_action('save_post', 'testdevwp_save_service_box');

add_action('add_meta_boxes', 'testdevwp_add_custom_service_price');
add_action('save_post', 'testdevwp_save_service_price');
