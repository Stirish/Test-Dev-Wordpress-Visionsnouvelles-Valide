<?php if(!function_exists('testdevwp_autocomplete_services')) {
    function testdevwp_autocomplete_services(){
        $term_name = wp_unslash( $_GET['q'] );
        $args = [
            'taxonomy' => 'services_types',
            'hide_empty' => true,
            'name__like' => $term_name
        ];
        $terms = get_terms( $args );
        wp_send_json_success($terms, 200); //return
    }
    add_action('wp_ajax_testdevwp_autocomplete_services', 'testdevwp_autocomplete_services'); // Fires authenticated Ajax actions for logged-in users.
    add_action('wp_ajax_nopriv_testdevwp_autocomplete_services', 'testdevwp_autocomplete_services'); //Fires non-authenticated Ajax actions for logged-out users.
}
?>