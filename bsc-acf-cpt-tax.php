<?php
	 /*
	   Plugin Name: ACF Custom Post Types and Taxonomies
	   Plugin URI: https://www.bluesummitcreative.com
	   Version: 1.0
	   Author: Chris Chavez
	   License: GPL2
	   */
	
	function bsc_cpt() {
		
		if( function_exists('acf_add_options_page') ) {
			
			$option_page = acf_add_options_page(array(
				'page_title' 	=> 'Custom Post Types',
				'menu_title' 	=> 'Custom Post Types',
				'menu_slug' 	=> 'bsc-cpt-settings',
				'capability' 	=> 'edit_posts',
				'redirect' 	=> false
			));
		}
		
		if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array(
			'key' => 'cpt_setings',
			'title' => 'Custom Post Type Settings',
			'fields' => array(
				array(
					'key' => 'cpt_titles_key',
					'label' => 'Custom Post Type Titles',
					'name' => 'cpt_titles',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'bsc-cpt-settings',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));

		endif;
		
		$new_cpts = explode(',',get_field('cpt_titles', 'option'));
		
		foreach ($new_cpts as $new_cpt) {
			register_post_type(strtolower(str_replace(" ","_",$new_cpt)), array(
				'labels' => array('name' => __($new_cpt)),
				'public' => true,
				'has_archive' => true,
				'supports' => array('title', 'editor', 'post-formats', 'author', 'thumbnail', 'excerpt', 'revisions')
			));
			
			$cpt_args = array(
				'label'        => __($new_cpt . ' Categories'),
				'hierarchical' => true,
			);

			register_taxonomy( strtolower(str_replace(" ","_",$new_cpt)).'_categories', strtolower(str_replace(" ","_",$new_cpt)), $cpt_args );
			
		}
	}
	add_action( 'init', 'bsc_cpt' );

	add_post_type_support( 'bsc_cpt', 'post-formats' );

?>
