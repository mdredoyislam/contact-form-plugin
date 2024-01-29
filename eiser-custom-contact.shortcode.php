<?php

function sunset_contact_form($atts, $content = null){

    //[eiser_contact_form]

    //Get The Attribute
    $atts = shortcode_atts( 
        array(),
        $atts,
        'eiser_contact_form', 
    );
    //return HTML
    ob_start();
    include 'template/contact-form.php';
    return ob_get_clean();
}
add_shortcode('eiser_contact_form','sunset_contact_form');