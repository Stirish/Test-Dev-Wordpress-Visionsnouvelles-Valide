<?php

function testdevwp_supports()
{
   add_theme_support('title-tag');
   add_theme_support('post-thumbnails');
   add_image_size('single-services-img', 350, 350, true);
}
add_action('after_setup_theme', 'testdevwp_supports');


function testdevwp_register_assets()
{

   wp_register_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', []);
   wp_register_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', ['popper', 'jquery'], false, true);
   wp_register_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', [], false, true);
   
   wp_enqueue_style('bootstrap');
   wp_enqueue_script('bootstrap-js');
   wp_enqueue_script('jquery');
   wp_enqueue_style('testdevwp-style', get_stylesheet_uri(), [], 1.0);
   wp_enqueue_style('testdevwp-bundle', get_template_directory_uri() . '/style.css', array(), 1.0);

   wp_register_script('testdevwp-form-js', get_stylesheet_directory_uri() . '/js/form.js');

   wp_localize_script(
      'testdevwp-form-js',
      'testdevwp_form_object',
      [
         'ajaxurl' => admin_url('admin-ajax.php'),
         'formError' => esc_html__('Please fill required fields!', 'testdevwp'),
      ]
   );
   
   wp_enqueue_script('testdevwp-form-js');
   
}
add_action('wp_enqueue_scripts', 'testdevwp_register_assets');


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
add_action('init', 'testdevwp_init');

//--------------Fontion pour prendre un template part

function vn_get_id_by_page_template($page_template)
{
   if ($page_template) {
      $args = array(
            'post_type' => 'page',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'meta_key' => '_wp_page_template',
            'meta_value' => $page_template,
            'suppress_filters' => 0
            //récupération de la page dans la langue courante
      );
      $page = get_posts($args);
      $page_id = isset($page) && !empty($page) && count($page) > 0 ? $page[0] : false;
      //page_id peut être l'ID de la page ou le lien de l'accueil
   } else {
      $page_id = false;
   }

   return $page_id;
}

function vn_get_permalink_by_page_template($page_template, $return_home_page_if_not_exist = true)
{
   if ($page_template) {
      $page_id = vn_get_id_by_page_template($page_template);
      //page_id peut être l'ID de la page ou le lien de l'accueil
      $page_permalink = (is_int($page_id)) ? get_permalink($page_id) : false;
      $page_permalink = (!$page_permalink && $return_home_page_if_not_exist) ? get_home_url() : $page_permalink;

   } else {
      $page_permalink = ($return_home_page_if_not_exist) ? get_home_url() : false;
   }

   return $page_permalink;
}

// ------------------ Metaboxes

require get_template_directory() . '/inc/metaboxes/init.php'; 

// ------------------ Block Gutenberg

require get_template_directory() . '/inc/gutenberg-blocks/init.php';

// ------- Function AJAX pour traitement des données et envoi de mail

require get_template_directory() . '/inc/functions-ajax.php';
require get_template_directory() . '/inc/testdevwp-functions.php';
require get_template_directory() . '/inc/classes/class-wp-mail.php';