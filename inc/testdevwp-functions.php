<?php
function checkRequireValue($requires = [], $sanitize = false)
{
    $sanatize_array = [];
    foreach ($requires as $key => $value) {
        $checkType = false;
        if (is_array($value)) {
            $checkType = true;
        }

        $result = (!$checkType) ? issetValueAndDontEmpty($value, [], $sanitize) : issetValueAndDontEmpty($key, $value, $sanitize);

        //        var_dump($key . ',' . $value . ' => ' . $result);

        if (!$result) {
            return null;
        } else {
            if ($sanitize) {
                if ($checkType) {
                    $sanatize_array[$key] = $result;
                } else {
                    $sanatize_array[$value] = $result;
                }
            }
        }
    }
    return (is_array($sanatize_array)) ? $sanatize_array : true;
}

function issetValueAndDontEmpty($input, $type_check = [], $sanitize = false)
{
    $result = false;
    $result = (isset($_POST[$input]) && $_POST[$input] != '') ? $_POST[$input] : $result;
    $result = (isset($_FILES[$input]) && $_FILES[$input] != '') ? $input : $result;

    if (empty($result)) {
        return false;
    }

    return (empty($type_check)) ? $result : checkType($result, $type_check, $sanitize);
}

function checkType($input, $type_check, $sanitize = false)
{
    $return = true;
    if (isset($type_check['type'])) {
        switch ($type_check['type']) {
            case 'email':
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $return = false;
                } else {
                    $return = ($sanitize) ? sanitize_email($input) : true;
                }
                break;

            case 'textarea':
                $return = ($sanitize) ? sanitize_textarea_field($input) : true;
                break;

            case 'int':
                $return = $input;
                break;

            case 'file':
                if (checkTypeFile($input, $type_check)) {
                    if ($sanitize) {
                        if (!function_exists('wp_handle_upload')) {
                            require_once(ABSPATH . 'wp-admin/includes/file.php');
                        }
                        $file = $_FILES[$input];

                        $upload_overrides = array('test_form' => false);
                        $return = wp_handle_upload($file, $upload_overrides);
                        if (!$return || isset($return['error'])) {
                            $message = __('Bad file type.', 'navi-france');
                            wp_send_json_error(array('message' => "<div class='alert alert-danger'>" . $message . "</div>"));
                        }
                        $return = $return['file'];
                    } else {
                        $return = true;
                    }
                } else {
                    $return = false;
                }
                break;

            default:
                wp_send_json_error(["message" => "<div class='alert alert-danger'>Type <u>" . $type_check['type']  . "</u> does not exist.</div>"]);
                break;
        }
    } else if ($sanitize) {
        $return = sanitize_text_field($_POST[$input]);
    }

    return $return;
}

function checkTypeFile($input, $type_check)
{
    if (!empty($type_check['min_size']) && $_FILES[$input]['size'] <= $type_check['min_size']) {
        return false;
    }

    if (!empty($type_check['max_size']) && $_FILES[$input]['size'] >= $type_check['max_size']) {
        return false;
    }

    return true;
}

function testdevwp_send_mail_info()
{
    $name = 'S.Florent';
    $email = get_option('admin_email');

    //$cc_fields = '';
    //$bcc_fields = '';

    $cc = [];
    $bcc = [];
    /*$cc_fields_array = explode(',', $cc_fields);
    if (is_array($cc_fields_array)) {
        foreach ($cc_fields_array as $cc_field) {
            if (is_email($cc_field)) {
                $cc[] = $cc_field;
            }
        }
    }

    
    $bcc_fields_array = explode(',', $bcc_fields);
    if (is_array($bcc_fields_array)) {
        foreach ($bcc_fields_array as $bcc_field) {
            if (is_email($bcc_field)) {
                $bcc[] = $bcc_field;
            }
        }
    }

    
    if( empty( $bcc ) ) {
    $bcc[] = 'admin <' . get_option('admin_email') . '>';
    }*/

    $fields = [
        'name'  => $name,
        'email' => $email,
        'cc'    => $cc,
        'bcc'   => $bcc,
    ];

    return $fields;
}