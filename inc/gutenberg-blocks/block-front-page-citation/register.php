<?php

if ( ! function_exists( 'SF_register_block_type' ) ) {
	return;
}

function SF_register_block_type()
{   
   acf_register_block_type([
      'name' => 'citation-posts',
      'title' => 'Bloc de citation (custom)',
      'render_template' => 'inc/gutenberg-blocks/block-front-page-citation/render.php',
   ]);

   acf_add_local_field_group([
      'key' => 'citation_group',
      'title' => 'Citation',
      'fields' => [
         [
            'key' => 'citation_text',
            'label' => 'Citation',
            'name' => 'citation',
            'type' => 'wysiwyg',
         ],
         [
            'key' => 'citation_author',
            'label' => 'Author',
            'name' => 'author',
            'type' => 'text',
            
         ],
      ],
      'location' => [
         [
            [
               'param' => 'block',
               'operator' => '==',
               'value' => 'acf/citation-posts',
            ]
         ]
      ],
      'active' => true,
   ]);
}
add_action('acf/init', 'SF_register_block_type');