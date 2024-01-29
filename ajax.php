<?php
add_action('wp_ajax_noprev_eiser_save_user_contact_form', 'eiser_save_contact');
add_action('wp_ajax_eiser_save_user_contact_form', 'eiser_save_contact');
function eiser_save_contact(){
    $name = wp_strip_all_tags( $_POST['name']);
    $email = wp_strip_all_tags( $_POST['email']);
    $message = wp_strip_all_tags( $_POST['message']);
    $args = array(
        'post_title' => $name,
        'post_content' => $message,
        'post_author' => 1,
        'post_status' => 'publish',
        'post_type'   => 'eiser_contact_form',
        'meta_input'  => array(
            '_contact_email_value_key' => $email,
        )
    );
    $postid = wp_insert_post($args);
    echo $postid;

    if($postid !== 0){
        $to = get_bloginfo('admin_email');
        $subject = 'eiser Contact Form'.$name;
        $headers[] = 'Form'.get_bloginfo('name').'<'.$to.'>'; //Form Contact eiser@gmail.com
        $headers[] = 'Replay To'.$name.'<'.$email.'>';
        $headers[] = 'Content-type: text/html; charset-UTF-8';
        
        wp_mail( $to, $subject, $message, $headers);
        echo $postid;
    }else{
        echo 0;
    }

    die();
}