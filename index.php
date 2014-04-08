<?php

/*
Plugin Name: Ebor Custom Post Types
Plugin URI: http://www.madeinebor.com
Description: Custom Post Types & Options for your theme.
Version: 1.3
Author: TommusRhodus
Author URI: http://www.madeinebor.com
*/	

//enqueue admin styles
function ebor_cpt_admin_style() {
	wp_enqueue_style( 'ebor-cpt-admin-styles', plugins_url( '/ebor-cpt-admin-styles.css' , __FILE__ ) );
}
add_action('admin_print_styles', 'ebor_cpt_admin_style', 90);

// Set-up Action and Filter Hooks
register_uninstall_hook(__FILE__, 'ebor_cpt_delete_plugin_options');
add_action('admin_init', 'ebor_cpt_init' );
add_action('admin_menu', 'ebor_cpt_add_options_page');
//RUN ON THEME ACTIVATION
register_activation_hook( __FILE__, 'ebor_cpt_activation' );

// Delete options table entries ONLY when plugin deactivated AND deleted
function ebor_cpt_delete_plugin_options() {
	delete_option('ebor_cpt_display_options');
}

// Flush rewrite rules on activation
function ebor_cpt_activation() {
	flush_rewrite_rules(true);
}

// Init plugin options to white list our options
function ebor_cpt_init(){
	register_setting( 'ebor_cpt_plugin_display_options', 'ebor_cpt_display_options', 'ebor_cpt_validate_display_options' );
}

// Add menu page
function ebor_cpt_add_options_page() {
	add_utility_page('Ebor CPT Options Page', 'Ebor CPT', 'manage_options', __FILE__, 'ebor_cpt_render_form');
}

$theme_name = wp_get_theme();

	if( $theme_name == 'ShadowBox' || $theme_name->parent() == 'ShadowBox' ) {
	
		require_once( plugin_dir_path( __FILE__ ) .'/themes/shadowbox.php' );
		
	} elseif( $theme_name == 'Seabird' || $theme_name->parent() == 'Seabird' ) {
	
		require_once( plugin_dir_path( __FILE__ ) .'/themes/seabird.php' );
		
	} elseif( $theme_name == 'Wiretree' || $theme_name->parent() == 'Wiretree' ) {
	
		require_once( plugin_dir_path( __FILE__ ) .'/themes/seabird.php' );
		
	} elseif( $theme_name == 'Kyte' || $theme_name->parent() == 'Kyte' ) {
	
		require_once( plugin_dir_path( __FILE__ ) .'/themes/kyte.php' );
	
	} elseif( $theme_name == 'Anchor' || $theme_name->parent() == 'Anchor' ) {
	
		require_once( plugin_dir_path( __FILE__ ) .'/themes/anchor.php' );
		
	} elseif( $theme_name == 'Other' || $theme_name->parent() == 'Other' || $theme_name == 'Tides' || $theme_name->parent() == 'Tides' || $theme_name == 'Greenwich Village' || $theme_name->parent() == 'Greenwich Village' ) {
	
		require_once( plugin_dir_path( __FILE__ ) .'/themes/other.php' );
	
	} else {
	
		require_once( plugin_dir_path( __FILE__ ) .'/themes/default.php' );
		
	}

//VALIDATE POST TYPE INPUTS
function ebor_cpt_validate_display_options($input) {
	if( get_option('ebor_cpt_display_options') ){
		$displays = get_option('ebor_cpt_display_options');
	foreach ($displays as $key => $value) {
		if(isset($input[$key])){
			$input[$key] = wp_filter_nohtml_kses($input[$key]);
		}
	}
	}
	return $input;
}

function register_portfolio() {

$displays = get_option('ebor_cpt_display_options');

if( $displays['portfolio_slug'] ){ $slug = $displays['portfolio_slug']; } else { $slug = 'portfolio'; }

//HERE'S AN ARRAY OF LABELS FOR PORTFOLIOS
    $labels = array( 
        'name' => __( 'Portfolio', 'ebor' ),
        'singular_name' => __( 'Portfolio', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Portfolio', 'ebor' ),
        'edit_item' => __( 'Edit Portfolio', 'ebor' ),
        'new_item' => __( 'New Portfolio', 'ebor' ),
        'view_item' => __( 'View Portfolio', 'ebor' ),
        'search_items' => __( 'Search Portfolios', 'ebor' ),
        'not_found' => __( 'No portfolios found', 'ebor' ),
        'not_found_in_trash' => __( 'No portfolios found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Portfolio:', 'ebor' ),
        'menu_name' => __( 'Portfolio', 'ebor' ),
    );

//AND HERE'S AN ARRAY OF ARGUMENTS TO DEFINE PORTFOLIOS FUNCTIONALITY
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Portfolio entries for the ebor Theme.', 'ebor'),
        'supports' => array( 'title', 'editor', 'thumbnail', 'post-formats', 'comments' ),
        'taxonomies' => array( 'portfolio-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'portfolio', $args );
}

//ADD PORTFOLIO TAXONOMY
function create_portfolio_taxonomies(){
	$labels = array(
	    'name' => _x( 'Portfolio Categories','ebor' ),
	    'singular_name' => _x( 'Portfolio Category','ebor' ),
	    'search_items' =>  __( 'Search Portfolio Categories','ebor' ),
	    'all_items' => __( 'All Portfolio Categories','ebor' ),
	    'parent_item' => __( 'Parent Portfolio Category','ebor' ),
	    'parent_item_colon' => __( 'Parent Portfolio Category:','ebor' ),
	    'edit_item' => __( 'Edit Portfolio Category','ebor' ), 
	    'update_item' => __( 'Update Portfolio Category','ebor' ),
	    'add_new_item' => __( 'Add New Portfolio Category','ebor' ),
	    'new_item_name' => __( 'New Portfolio Category Name','ebor' ),
	    'menu_name' => __( 'Portfolio Categories','ebor' ),
	  ); 	
	
	// Now register the taxonomy
	
	  register_taxonomy('portfolio-category', array('portfolio'), array(
	    'hierarchical' => true,
	    'labels' => $labels,
	    'show_ui' => true,
	    'show_admin_column' => true,
	    'query_var' => true,
	    'rewrite' => true,
	  ));
}



function register_team() {

$displays = get_option('ebor_cpt_display_options');

if( $displays['team_slug'] ){ $slug = $displays['team_slug']; } else { $slug = 'team'; }

//HERE'S AN ARRAY OF LABELS FOR TEAM MEMBERS
    $labels = array( 
        'name' => __( 'Team Members', 'ebor' ),
        'singular_name' => __( 'Team Member', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Team Member', 'ebor' ),
        'edit_item' => __( 'Edit Team Member', 'ebor' ),
        'new_item' => __( 'New Team Member', 'ebor' ),
        'view_item' => __( 'View Team Member', 'ebor' ),
        'search_items' => __( 'Search Team Members', 'ebor' ),
        'not_found' => __( 'No Team Members found', 'ebor' ),
        'not_found_in_trash' => __( 'No Team Members found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Team Member:', 'ebor' ),
        'menu_name' => __( 'Team Members', 'ebor' ),
    );

//AND HERE'S AN ARRAY OF ARGUMENTS TO DEFINE TEAM MEMBERS FUNCTIONALITY
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Team Member entries for the ebor Theme.', 'ebor'),
        'supports' => array( 'title', 'thumbnail', 'editor' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'team', $args );
}

//HERE'S THE FUNCTION TO DO IT
function register_client() {

//HERE'S AN ARRAY OF LABELS FOR CLIENT
    $labels = array( 
        'name' => __( 'Clients', 'ebor' ),
        'singular_name' => __( 'Client', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Client', 'ebor' ),
        'edit_item' => __( 'Edit Client', 'ebor' ),
        'new_item' => __( 'New Client', 'ebor' ),
        'view_item' => __( 'View Client', 'ebor' ),
        'search_items' => __( 'Search Clients', 'ebor' ),
        'not_found' => __( 'No Clients found', 'ebor' ),
        'not_found_in_trash' => __( 'No Clients found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Client:', 'ebor' ),
        'menu_name' => __( 'Clients', 'ebor' ),
    );

//AND HERE'S AN ARRAY OF ARGUMENTS TO DEFINE CLIENTS FUNCTIONALITY
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Client entries for the EL Theme.', 'ebor'),
        'supports' => array( 'title', 'thumbnail' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'client', $args );
}