<?php
/*
Plugin Name: StartUp CPT Events
Description: Le plugin pour activer le Custom Post Events
Author: Yann Caplain
Version: 1.0.0
Text Domain: startup-cpt-events
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//Include this to check if a plugin is activated with is_plugin_active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

//Include this to check dependencies
include_once( 'inc/dependencies.php' );

//GitHub Plugin Updater
function startup_cpt_events_updater() {
	include_once 'lib/updater.php';
	//define( 'WP_GITHUB_FORCE_UPDATE', true );
	if ( is_admin() ) {
		$config = array(
			'slug' => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'startup-cpt-events',
			'api_url' => 'https://api.github.com/repos/yozzi/startup-cpt-events',
			'raw_url' => 'https://raw.github.com/yozzi/startup-cpt-events/master',
			'github_url' => 'https://github.com/yozzi/startup-cpt-events',
			'zip_url' => 'https://github.com/yozzi/startup-cpt-events/archive/master.zip',
			'sslverify' => true,
			'requires' => '3.0',
			'tested' => '3.3',
			'readme' => 'README.md',
			'access_token' => '',
		);
		new WP_GitHub_Updater( $config );
	}
}

//add_action( 'init', 'startup_cpt_events_updater' );

//CPT
function startup_cpt_events() {
	$labels = array(
		'name'                => _x( 'Events', 'Post Type General Name', 'startup-cpt-events' ),
		'singular_name'       => _x( 'Events', 'Post Type Singular Name', 'startup-cpt-events' ),
		'menu_name'           => __( 'Events', 'startup-cpt-events' ),
		'name_admin_bar'      => __( 'Events', 'startup-cpt-events' ),
		'parent_item_colon'   => __( 'Parent Item:', 'startup-cpt-events' ),
		'all_items'           => __( 'All Items', 'startup-cpt-events' ),
		'add_new_item'        => __( 'Add New Item', 'startup-cpt-events' ),
		'add_new'             => __( 'Add New', 'startup-cpt-events' ),
		'new_item'            => __( 'New Item', 'startup-cpt-events' ),
		'edit_item'           => __( 'Edit Item', 'startup-cpt-events' ),
		'update_item'         => __( 'Update Item', 'startup-cpt-events' ),
		'view_item'           => __( 'View Item', 'startup-cpt-events' ),
		'search_items'        => __( 'Search Item', 'startup-cpt-events' ),
		'not_found'           => __( 'Not found', 'startup-cpt-events' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'startup-cpt-events' )
	);
	$args = array(
		'label'               => __( 'events', 'startup-cpt-events' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-calendar-alt',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
        'capability_type'     => array('event','events'),
        'map_meta_cap'        => true,
        'rewrite' => array(
                'slug' => 'movies'
            )
	);
	register_post_type( 'events', $args );
}

add_action( 'init', 'startup_cpt_events', 0 );

//Flusher les permalink à l'activation du plugin pour qu'ils fonctionnent sans mise à jour manuelle
function startup_cpt_events_rewrite_flush() {
    startup_cpt_events();
    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'startup_cpt_events_rewrite_flush' );

// Capabilities
function startup_cpt_events_caps() {
	$role_admin = get_role( 'administrator' );
	$role_admin->add_cap( 'edit_event' );
	$role_admin->add_cap( 'read_event' );
	$role_admin->add_cap( 'delete_event' );
	$role_admin->add_cap( 'edit_others_events' );
	$role_admin->add_cap( 'publish_events' );
	$role_admin->add_cap( 'edit_events' );
	$role_admin->add_cap( 'read_private_events' );
	$role_admin->add_cap( 'delete_events' );
	$role_admin->add_cap( 'delete_private_events' );
	$role_admin->add_cap( 'delete_published_events' );
	$role_admin->add_cap( 'delete_others_events' );
	$role_admin->add_cap( 'edit_private_events' );
	$role_admin->add_cap( 'edit_published_events' );
}

register_activation_hook( __FILE__, 'startup_cpt_events_caps' );

// Events taxonomy
function startup_cpt_events_categories() {
	$labels = array(
		'name'                       => _x( 'Event Categories', 'Taxonomy General Name', 'startup-cpt-events' ),
		'singular_name'              => _x( 'Event Category', 'Taxonomy Singular Name', 'startup-cpt-events' ),
		'menu_name'                  => __( 'Event Categories', 'startup-cpt-events' ),
		'all_items'                  => __( 'All Items', 'startup-cpt-events' ),
		'parent_item'                => __( 'Parent Item', 'startup-cpt-events' ),
		'parent_item_colon'          => __( 'Parent Item:', 'startup-cpt-events' ),
		'new_item_name'              => __( 'New Item Name', 'startup-cpt-events' ),
		'add_new_item'               => __( 'Add New Item', 'startup-cpt-events' ),
		'edit_item'                  => __( 'Edit Item', 'startup-cpt-events' ),
		'update_item'                => __( 'Update Item', 'startup-cpt-events' ),
		'view_item'                  => __( 'View Item', 'startup-cpt-events' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'startup-cpt-events' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'startup-cpt-events' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'startup-cpt-events' ),
		'popular_items'              => __( 'Popular Items', 'startup-cpt-events' ),
		'search_items'               => __( 'Search Items', 'startup-cpt-events' ),
		'not_found'                  => __( 'Not Found', 'startup-cpt-events' )
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false
	);
	register_taxonomy( 'event-category', array( 'events' ), $args );

}

//add_action( 'init', 'startup_cpt_events_categories', 0 );

// Retirer la boite de la taxonomie sur le coté
function startup_cpt_events_categories_metabox_remove() {
	remove_meta_box( 'tagsdiv-event-category', 'events', 'side' );
    // tagsdiv-product_types pour les taxonomies type tags
    // custom_taxonomy_slugdiv pour les taxonomies type categories
}

//add_action( 'admin_menu' , 'startup_cpt_events_categories_metabox_remove' );

// Metaboxes
function startup_cpt_events_meta() {
    require ABSPATH . 'wp-content/plugins/startup-cpt-events/inc/font-awesome.php';
    
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_startup_cpt_events_';

	$cmb_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Event details', 'startup-cpt-events' ),
		'object_types'  => array( 'events' )
	) );
    
//    $cmb_box->add_field( array(
//		'name'     => __( 'Categoy', 'startup-cpt-events' ),
//		'desc'     => __( 'Select the category(ies) of the event', 'startup-cpt-events' ),
//		'id'       => $prefix . 'category',
//		'type'     => 'taxonomy_multicheck',
//		'taxonomy' => 'event-category', // Taxonomy Slug
//		'inline'  => true // Toggles display to inline
//	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Date', 'startup-cpt-events' ),
		'id'         => $prefix . 'date',
		'type'       => 'text'
	) );
    
    $cmb_box->add_field( array(
		'name'             => __( 'Color', 'startup-cpt-events' ),
		'id'               => $prefix . 'color',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'jaune' => __( 'Jaune', 'startup-cpt-events' ),
			'rose'  => __( 'Rose', 'startup-cpt-events' ),
			'bleu'  => __( 'Bleu', 'startup-cpt-events' ),
            'vert'  => __( 'Vert', 'startup-cpt-events' ),
			'mauve' => __( 'Mauve', 'startup-cpt-events' ),
            'cyan'  => __( 'Cyan', 'startup-cpt-events' ),
		),
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Partner', 'startup-cpt-events' ),
		'id'         => $prefix . 'partner',
		'type'       => 'text'
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'Partner logo', 'startup-cpt-events' ),
		'id'   => $prefix . 'partner_logo',
		'type' => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false,
        ),
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Partner link', 'startup-cpt-events' ),
		'id'         => $prefix . 'partner_link',
		'type'       => 'text'
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Sponsor', 'startup-cpt-events' ),
		'id'         => $prefix . 'sponsor',
		'type'       => 'text'
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'Sponsor logo', 'startup-cpt-events' ),
		'id'   => $prefix . 'sponsor_logo',
		'type' => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false,
        ),
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Sponsor link', 'startup-cpt-events' ),
		'id'         => $prefix . 'sponsor_link',
		'type'       => 'text'
	) );
    
        $cmb_box->add_field( array(
		'name'       => __( 'Sponsor', 'startup-cpt-events' ),
		'id'         => $prefix . 'sponsor2',
		'type'       => 'text'
	) );
    
    $cmb_box->add_field( array(
		'name' => __( 'Sponsor logo', 'startup-cpt-events' ),
		'id'   => $prefix . 'sponsor_logo2',
		'type' => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false,
        ),
	) );
    
    $cmb_box->add_field( array(
		'name'       => __( 'Sponsor link', 'startup-cpt-events' ),
		'id'         => $prefix . 'sponsor_link2',
		'type'       => 'text'
	) );
    
    
    
    $cmb_box->add_field( array(
		'name'       => __( 'Map ID', 'startup-cpt-events' ),
		'id'         => $prefix . 'map',
		'type'       => 'text'
	) );

}

add_action( 'cmb2_admin_init', 'startup_cpt_events_meta' );

// Shortcode
function startup_cpt_events_shortcode( $atts ) {

	// Attributes
    $atts = shortcode_atts(array(
            'bg' => '#f0f0f0',
            'order' => '',
//            'cat' => '',
            'id' => '',
        ), $atts);
    
	// Code
    ob_start();
    if ( function_exists( 'startup_reloaded_setup' ) ) {
        require get_template_directory() . '/template-parts/content-events.php';
    } else {
        echo 'Should <a href="https://github.com/yozzi/startup-reloaded" target="_blank">install StartUp Reloaded Theme</a> to make things happen...';
    }
    return ob_get_clean();    
}
add_shortcode( 'events', 'startup_cpt_events_shortcode' );

// Shortcode UI
function startup_cpt_events_shortcode_ui() {

    shortcode_ui_register_for_shortcode(
        'events',
        array(
            'label' => esc_html__( 'Events', 'startup-cpt-events' ),
            'listItemImage' => 'dashicons-groups',
            'attrs' => array(
                array(
                    'label' => esc_html__( 'Background', 'startup-cpt-events' ),
                    'attr'  => 'bg',
                    'type'  => 'color',
                ),
                array(
                    'label' => esc_html__( 'Order', 'startup-cpt-events' ),
                    'attr'  => 'order',
                    'type' => 'select',
                    'options' => array(
                        'menu_order' => esc_html__( 'Menu Order', 'startup-cpt-events' ),
                        'rand' => esc_html__( 'Random', 'startup-cpt-events' )
                    ),
                ),
                array(
                    'label' => esc_html__( 'Category', 'startup-cpt-events' ),
                    'attr'  => 'cat',
                    'type'  => 'text',
                ),
                array(
                    'label' => esc_html__( 'ID', 'startup-cpt-events' ),
                    'attr'  => 'id',
					'type' => 'post_select',
					'query' => array( 'post_type' => 'events' ),
					'multiple' => false,
                ),
            ),
        )
    );
};

if ( function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
    add_action( 'init', 'startup_cpt_events_shortcode_ui');
}

// Enqueue scripts and styles.
function startup_cpt_events_scripts() {
    wp_enqueue_style( 'startup-cpt-events-style', plugins_url( '/css/startup-cpt-events.css', __FILE__ ), array( ), false, 'all' );
}

add_action( 'wp_enqueue_scripts', 'startup_cpt_events_scripts', 15 );
?>