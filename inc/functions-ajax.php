<?php

if (!defined('ABSPATH')) {
    die();
}

function testdevwp_submit_form()
{
    check_ajax_referer('ajax_contact_nonce', 'security');

    $parameters = checkRequireValue(
        [
            'last-name',
            'first-name',
            'email' => ['type' => 'email'],
            'object',
            'message' => ['type' => 'textarea'],
        ],
        true
    );
    
    if (empty($parameters)) {
        wp_send_json_error(['message' => esc_html('Please fill required fields!')]);
    } 
    

    $email = get_option('admin_email');

    if(wp_mail(
        $email,
        'Objet',
        'Un message',
    )) {
        wp_send_json_success(['message' => esc_html('Message send !')]);
    }
    else {
        wp_send_json_error(['message' => esc_html('NOT OK!')]);
    }

    
}

add_action('wp_ajax_testdevwp_submit_form', 'testdevwp_submit_form');
add_action('wp_ajax_nopriv_testdevwp_submit_form', 'testdevwp_submit_form');