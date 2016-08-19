<?php
/*
 * Plugin Name: Staff - Post Type Divi Widget
 * Plugin URI: http://mrkdevelopment.com
 * Description: Addon for Divi Widget for Staff post type.
 * Version: 1.0
 * Author: M R K Development
 * Author URI: http://mrkdevelopment.com
 * License: GPLv2 or later
 */
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// constants
define('MRK_STAFF_DIVI_WIDGET_DIR', __DIR__);
define('MRK_STAFF_DIVI_WIDGET_URL', plugins_url('/'.basename(__DIR__)));

require_once MRK_STAFF_DIVI_WIDGET_DIR.'/src/class-mrk-divi-widget-staff-post-type-activate.php';
register_activation_hook(__FILE__, array('MRK_Divi_Widget_Staff_Post_Type_Activate', 'activate'));

/**
 * Defines variables for
 * @return [type] [description]
 */
function register_mrk_divi_widget_staff_post_type()
{
    require_once MRK_STAFF_DIVI_WIDGET_DIR . '/src/widgets/MrkDiviWidgetStaffPostType.php';
}

add_action('et_builder_ready', 'register_mrk_divi_widget_staff_post_type', 1);

// Register Custom Post Type - Staff
function custom_post_type_staff()
{
    $labels = array(
        'name'                  => _x( 'Staffs', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Staff', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Staff', 'text_domain' ),
        'name_admin_bar'        => __( 'Staff', 'text_domain' ),
        'archives'              => __( 'Item Archives', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'All Items', 'text_domain' ),
        'add_new_item'          => __( 'Add New Item', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Item', 'text_domain' ),
        'edit_item'             => __( 'Edit Item', 'text_domain' ),
        'update_item'           => __( 'Update Item', 'text_domain' ),
        'view_item'             => __( 'View Item', 'text_domain' ),
        'search_items'          => __( 'Search Item', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Items list', 'text_domain' ),
        'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $rewrite = array(
        'slug'                  => 'staff',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Staff', 'text_domain' ),
        'description'           => __( 'Staff Post Type', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', ),
        'taxonomies'            => array( 'staff_taxonomy' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-id-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
    );
    register_post_type( 'staff', $args );
}
add_action( 'init', 'custom_post_type_staff', 0 );

// Register Custom Taxonomy
function custom_staff_taxonomy()
{
    $labels = array(
        'name'                       => _x( 'Staff Categories', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Staff', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Staff categories', 'text_domain' ),
        'all_items'                  => __( 'All Items', 'text_domain' ),
        'parent_item'                => __( 'Parent Item', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
        'new_item_name'              => __( 'New Item Name', 'text_domain' ),
        'add_new_item'               => __( 'Add New Item', 'text_domain' ),
        'edit_item'                  => __( 'Edit Item', 'text_domain' ),
        'update_item'                => __( 'Update Item', 'text_domain' ),
        'view_item'                  => __( 'View Item', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Items', 'text_domain' ),
        'search_items'               => __( 'Search Items', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No items', 'text_domain' ),
        'items_list'                 => __( 'Items list', 'text_domain' ),
        'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
    );
    $rewrite = array(
        'slug'                       => 'staff_categories',
        'with_front'                 => true,
        'hierarchical'               => false,
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite'                    => $rewrite,
    );
    register_taxonomy( 'staff_taxonomy', array( 'staff' ), $args );
}
add_action( 'init', 'custom_staff_taxonomy', 0 );
