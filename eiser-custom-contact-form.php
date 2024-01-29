<?php
/**
 * Eiser Custom Contact Form
 * Plugin Name: Eiser Custom Contact Form
 * Plugin URI:  https://wordpress.org/plugins/eiser-custom-contact-form/
 * Description: eiser-custom-contact-form
 * Version:     1.0.0
 * Author:      Md. Redoy Islam
 * Author URI:  https://github.com/redoyislam/eiser-custom-contact-form/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: eiser-custom-contact-form
 * Domain Path: /languages
 * Requires at least: 4.9
 * Tested up to: 5.8
 * Requires PHP: 5.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

function eiser_custom_contact_post_type() {
    $labels = array(
        'name' => 'Messages',
        'singular_name' => 'Message',
        'menu_name' => 'Message',
        'name_admin_bar' => 'Message',
        'add_new'               => __( 'Add Message' ),
    );
    $args = array(
        'labels'                => $labels,
        'supports'              => array('title','editor','author'),
		//'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
    );
    register_post_type('eiser_contact_form', $args);
}
add_action('init','eiser_custom_contact_post_type');


function eiser_set_custom_columns($columns){
    $newColumns = array();
    $newColumns['title'] = 'Full Name';
    $newColumns['message'] = 'Message';
    $newColumns['email'] = 'Email Address';
    $newColumns['date'] = 'Date';
    $newColumns['author'] = 'Author';

    return $newColumns;
}
add_filter('manage_eiser_contact_form_posts_columns', 'eiser_set_custom_columns', 10, 2);

function eiser_contact_custom_columns( $column, $post_id ){
    switch ($column) {
        case 'message':
            the_excerpt();
            break;
        case 'email':
            $value = get_post_meta($post_id, '_contact_email_value_key', true);
            echo "<a href='mailto:".$value."'>".$value."</a>";
            break;
    }
}
add_filter('manage_eiser_contact_form_posts_custom_column', 'eiser_contact_custom_columns', 10, 2);

/*
Contact Custom Metabox
*/
function eiser_contact_add_metabox(){
    add_meta_box( 'contact_email', 'User Email', 'eiser_contact_email_callable','eiser_contact_form', 'side');
}
add_action('add_meta_boxes', 'eiser_contact_add_metabox');

function eiser_contact_email_callable($post){
    wp_nonce_field('eiser_save_email_data','eiser_contact_email_metabox_nonce');
    $value = get_post_meta($post->ID, '_contact_email_value_key', true);
    echo "<label for='eiser_contact_email_field'>Email:</label> ";
    echo "<input type='email' id='eiser_contact_email_field' name='eiser_contact_email_field' size='25' value='". esc_attr($value) ."'>";
}

function eiser_save_email_data($post_id){
    if(!isset($_POST['eiser_contact_email_metabox_nonce'])){
        return;
    }
    if(!wp_verify_nonce($_POST['eiser_contact_email_metabox_nonce'],'eiser_save_email_data')){
        return;
    }
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
        return;
    }
    if(!current_user_can('edit_post', $post_id)){
        return;
    }
    if(!isset($_POST['eiser_contact_email_field'])){
        return;
    }

    $my_data = sanitize_text_field($_POST['eiser_contact_email_field']);
    update_post_meta( $post_id, '_contact_email_value_key', $my_data );
}
add_action('save_post','eiser_save_email_data');

require_once dirname(__FILE__).'./eiser-custom-contact.shortcode.php';
require_once dirname(__FILE__).'./ajax.php';

function eiser_enquee_contact_script(){
    wp_enqueue_style('eiser-custom-form', plugins_url('css/eiser-custom-form.css', __FILE__) );

    wp_enqueue_script('jquery');
    wp_enqueue_script('eiser-scripts', plugins_url('js/script.js', __FILE__));
}
add_action('wp_enqueue_scripts','eiser_enquee_contact_script');