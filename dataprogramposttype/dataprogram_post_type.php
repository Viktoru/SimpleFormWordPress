<?php
/**
 * Plugin Name: Data Program Post Type
 * Plugin URI: http://wordpress.dataprogram.info
 * Description: Adding a Post Type example.
 * Version: 1.0
 * Author: Victor P. Unda
 * Author URI: http://www.intillajta.org
 **/

function dataprogram_custom_post_type()
{
  global $wp_post_types;

  if ( ! is_array( $wp_post_types ) ) {
    $wp_post_types = array();
  }

  register_post_type('dataprogramPostType',
    array(
      'labels'=>array(
        'name'=>__('Data Program'),
        'singular_name' =>__('Crop & Cultivar')
      ),
      'menu_position'=>6,
      'menu_icon'   => 'dashicons-archive',
      'public'=>true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'show_in_nav_menus' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'show_in_admin_bar' => true,
      'can_export' => true,
      'delete_with_user' => true,
      'hierarchical' => false,
      'has_archive' => false,
      'query_var' => true,
      'capability_type' => 'post',
      'map_meta_cap' => true,

      'supports'=>array('title','editor','thumbnail')
    )

    );

}

add_action('init','dataprogram_custom_post_type', 0);
