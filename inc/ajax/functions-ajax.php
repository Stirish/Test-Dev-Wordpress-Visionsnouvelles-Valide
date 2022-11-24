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

    $sendMailInfo = testdevwp_send_mail_info();

    $mailInfo = WP_Mail::init()

    ->to($sendMailInfo['email'])
    ->from(sprintf('%1$s %2$s <%3$s>', $parameters['first-name'], $parameters['last-name'], $parameters['email']))
    ->bcc($sendMailInfo['bcc'])
    ->cc($sendMailInfo['cc'])
    ->subject(esc_html('Contact from your website'))
    ->template(get_template_directory() . '/inc/email-templates/template-mail.php', $parameters)
    ->send();

    

    if (!$mailInfo) {

        wp_send_json_error(['message' => esc_html('Message not send !')]);
    }
    
    $redirectUrl = vn_get_permalink_by_page_template('page-template/page-confirmation.php');

    wp_send_json_success(
        [
            'message' => esc_html('Message send !'),
            'redirect' => $redirectUrl,
        ]
    );
}

add_action('wp_ajax_testdevwp_submit_form', 'testdevwp_submit_form');
add_action('wp_ajax_nopriv_testdevwp_submit_form', 'testdevwp_submit_form');
