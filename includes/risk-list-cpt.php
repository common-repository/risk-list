<?php

 if ( ! defined( 'RISKLIST_PATH' ) ) exit;

/* ======================================================
	Custom Post Types
   ====================================================== */

#COMMENT} Setup Custom Post Types
function risklist_setupPostTypes() {
	global $risklist_slugs;

		$labels = array(
			'name'                       => _x( 'Objective Tags', 'Objective Tags', 'Objectivelist' ),
			'singular_name'              => _x( 'Objective Tag', 'Objective Tag', 'Objectivelist' ),
			'menu_name'                  => __( 'Objective Tags', 'Objectivelist' ),
			'all_items'                  => __( 'All Tags', 'Objectivelist' ),
			'parent_item'                => __( 'Parent Tag', 'Objectivelist' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'Objectivelist' ),
			'new_item_name'              => __( 'New Tag Name', 'Objectivelist' ),
			'add_new_item'               => __( 'Add Tag Item', 'Objectivelist' ),
			'edit_item'                  => __( 'Edit Tag', 'Objectivelist' ),
			'update_item'                => __( 'Tag Item', 'Objectivelist' ),
			'view_item'                  => __( 'View Tag', 'Objectivelist' ),
			'separate_items_with_commas' => __( 'Separate Tags with commas', 'Objectivelist' ),
			'add_or_remove_items'        => __( 'Add or remove Tags', 'Objectivelist' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'Objectivelist' ),
			'popular_items'              => __( 'Popular Tags', 'Objectivelist' ),
			'search_items'               => __( 'Search Tags', 'Objectivelist' ),
			'not_found'                  => __( 'Not Found', 'Objectivelist' ),
			'no_terms'                   => __( 'No Tags', 'Objectivelist' ),
			'items_list'                 => __( 'Tags list', 'Objectivelist' ),
			'items_list_navigation'      => __( 'Tags list navigation', 'Objectivelist' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
			'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_taxonomy( 'risklist_objectivetag', array( 'risklist_objectivetag' ), $args );


		$labels = array(
			'name'                  => _x( 'Objectives', 'Objectives', 'Objectivelist' ),
			'singular_name'         => _x( 'Objective', 'Objective', 'Objectivelist' ),
			'menu_name'             => __( 'Objectives', 'Objectivelist' ),
			'name_admin_bar'        => __( 'Objective', 'Objectivelist' ),
			'archives'              => __( 'Objective Archives', 'Objectivelist' ),
			'parent_item_colon'     => __( 'Objective:', 'Objectivelist' ),
			'parent'    			=> __( 'Objective', 'Objectivelist' ),
			'all_items'             => __( 'Objectives', 'Objectivelist' ),
			'add_new_item'          => __( 'Add New Objective', 'Objectivelist' ),
			'add_new'               => __( 'Add New', 'Objectivelist' ),
			'new_item'              => __( 'New Objective', 'Objectivelist' ),
			'edit_item'             => __( 'Edit Objective', 'Objectivelist' ),
			'update_item'           => __( 'Update Objective', 'Objectivelist' ),
			'view_item'             => __( 'View Objective', 'Objectivelist' ),
			'search_items'          => __( 'Search Objective', 'Objectivelist' ),
			'not_found'             => __( 'Not found', 'Objectivelist' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'Objectivelist' ),
			'featured_image'        => __( 'Objective Image', 'Objectivelist' ),
			'set_featured_image'    => __( 'Set Objective image', 'Objectivelist' ),
			'remove_featured_image' => __( 'Remove Objective image', 'Objectivelist' ),
			'use_featured_image'    => __( 'Use as Objective image', 'Objectivelist' ),
			'insert_into_item'      => __( 'Insert into Objective', 'Objectivelist' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Objective', 'Objectivelist' ),
			'items_list'            => __( 'Objectives list', 'Objectivelist' ),
			'items_list_navigation' => __( 'Objectives list navigation', 'Objectivelist' ),
			'filter_items_list'     => __( 'Filter Objectives list', 'Objectivelist' ),
		);
		$args = array(
			'label'                 => __( 'Objective', 'Objectivelist' ),
			'description'           => __( 'Objective', 'Objectivelist' ),
			'labels'                => $labels,
			'supports'              => array(  'title','editor','taxonomies', 'author', 'revisions'), #, 'page-attributes'
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => true, #Objectivelist_getSetting('companylevelcustomers'), #} Will be true if b2b on
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => $risklist_slugs['home'],
			'menu_position'         => "24",
			'menu_icon'             => 'dashicons-networking',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => false,
			'has_archive'           => false,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'taxonomies' 			=> array('Objectivelist_Objectivetag'),
			'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_post_type( 'risklist_objective', $args );

		$labels = array(
			'name'                       => _x( 'Risk Tags', 'Risk Tags', 'risklist' ),
			'singular_name'              => _x( 'Risk Tag', 'Risk Tag', 'risklist' ),
			'menu_name'                  => __( ' Risk Tags', 'risklist' ),
			'all_items'                  => __( 'All Tags', 'risklist' ),
			'parent_item'                => __( 'Parent Tag', 'risklist' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'risklist' ),
			'new_item_name'              => __( 'New Tag Name', 'risklist' ),
			'add_new_item'               => __( 'Add Tag Item', 'risklist' ),
			'edit_item'                  => __( 'Edit Tag', 'risklist' ),
			'update_item'                => __( 'Tag Item', 'risklist' ),
			'view_item'                  => __( 'View Tag', 'risklist' ),
			'separate_items_with_commas' => __( 'Separate Tags with commas', 'risklist' ),
			'add_or_remove_items'        => __( 'Add or remove Tags', 'risklist' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'risklist' ),
			'popular_items'              => __( 'Popular Tags', 'risklist' ),
			'search_items'               => __( 'Search Tags', 'risklist' ),
			'not_found'                  => __( 'Not Found', 'risklist' ),
			'no_terms'                   => __( 'No Tags', 'risklist' ),
			'items_list'                 => __( 'Tags list', 'risklist' ),
			'items_list_navigation'      => __( 'Tags list navigation', 'risklist' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
						'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks',
		    )
		);
		register_taxonomy( 'risklist_risktag', array( 'risklist_risktag' ), $args );


		$labels = array(
			'name'                  => _x( 'Risks', 'Risks', 'risklist' ),
			'singular_name'         => _x( 'Risk', 'Risk', 'risklist' ),
			'menu_name'             => __( 'Risks', 'risklist' ),
			'name_admin_bar'        => __( 'Risk', 'risklist' ),
			'archives'              => __( 'Risk Archives', 'risklist' ),
			'parent_item_colon'     => __( 'Risk:', 'risklist' ),
			'parent'    			=> __( 'Risk', 'risklist' ),
			'all_items'             => __( 'Risks', 'risklist' ),
			'add_new_item'          => __( 'Add New Risk', 'risklist' ),
			'add_new'               => __( 'Add New', 'risklist' ),
			'new_item'              => __( 'New Risk', 'risklist' ),
			'edit_item'             => __( 'Edit Risk', 'risklist' ),
			'update_item'           => __( 'Update Risk', 'risklist' ),
			'view_item'             => __( 'View Risk', 'risklist' ),
			'search_items'          => __( 'Search Risk', 'risklist' ),
			'not_found'             => __( 'Not found', 'risklist' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'risklist' ),
			'featured_image'        => __( 'Risk Image', 'risklist' ),
			'set_featured_image'    => __( 'Set Risk image', 'risklist' ),
			'remove_featured_image' => __( 'Remove Risk image', 'risklist' ),
			'use_featured_image'    => __( 'Use as Risk image', 'risklist' ),
			'insert_into_item'      => __( 'Insert into Risk', 'risklist' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Risk', 'risklist' ),
			'items_list'            => __( 'Risks list', 'risklist' ),
			'items_list_navigation' => __( 'Risks list navigation', 'risklist' ),
			'filter_items_list'     => __( 'Filter Risks list', 'risklist' ),
		);
		$args = array(
			'label'                 => __( 'Risk', 'risklist' ),
			'description'           => __( 'Risk', 'risklist' ),
			'labels'                => $labels,
			'supports'              => array(  'title','editor','taxonomies', 'author', 'revisions', 'page-attributes'), #, 'page-attributes'
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => true, 
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => $risklist_slugs['home'],
			'menu_position'         => "25.3",
			'menu_icon'             => 'dashicons-sos',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => false,
			'has_archive'           => false,		
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'taxonomies' 			=> array('risklist_risktag'),
			'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks',
		    )
		);
		register_post_type( 'risklist_risk', $args );

		$labels = array(
			'name'                       => _x( 'Metric Tags', 'Metric Tags', 'risklist' ),
			'singular_name'              => _x( 'Metric Tag', 'Metric Tag', 'risklist' ),
			'menu_name'                  => __( ' Metric Tags', 'risklist' ),
			'all_items'                  => __( 'All Tags', 'risklist' ),
			'parent_item'                => __( 'Parent Tag', 'risklist' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'risklist' ),
			'new_item_name'              => __( 'New Tag Name', 'risklist' ),
			'add_new_item'               => __( 'Add Tag Item', 'risklist' ),
			'edit_item'                  => __( 'Edit Tag', 'risklist' ),
			'update_item'                => __( 'Tag Item', 'risklist' ),
			'view_item'                  => __( 'View Tag', 'risklist' ),
			'separate_items_with_commas' => __( 'Separate Tags with commas', 'risklist' ),
			'add_or_remove_items'        => __( 'Add or remove Tags', 'risklist' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'risklist' ),
			'popular_items'              => __( 'Popular Tags', 'risklist' ),
			'search_items'               => __( 'Search Tags', 'risklist' ),
			'not_found'                  => __( 'Not Found', 'risklist' ),
			'no_terms'                   => __( 'No Tags', 'risklist' ),
			'items_list'                 => __( 'Tags list', 'risklist' ),
			'items_list_navigation'      => __( 'Tags list navigation', 'risklist' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
			'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_taxonomy( 'risklist_metrics', array( 'risklist_metrics' ), $args );


		$labels = array(
			'name'                  => _x( 'Metrics', 'Metrics', 'risklist' ),
			'singular_name'         => _x( 'Metric', 'Metric', 'risklist' ),
			'menu_name'             => __( 'Metrics', 'risklist' ),
			'name_admin_bar'        => __( 'Metric', 'risklist' ),
			'archives'              => __( 'Metric Archives', 'risklist' ),
			'parent_item_colon'     => __( 'Metric:', 'risklist' ),
			'parent'    			=> __( 'Metric', 'risklist' ),
			'all_items'             => __( 'Metrics', 'risklist' ),
			'add_new_item'          => __( 'Add New Metric', 'risklist' ),
			'add_new'               => __( 'Add New', 'risklist' ),
			'new_item'              => __( 'New Metric', 'risklist' ),
			'edit_item'             => __( 'Edit Metric', 'risklist' ),
			'update_item'           => __( 'Update Metric', 'risklist' ),
			'view_item'             => __( 'View Metric', 'risklist' ),
			'search_items'          => __( 'Search Metrics', 'risklist' ),
			'not_found'             => __( 'Not found', 'risklist' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'risklist' ),
			'items_list'            => __( 'Metric list', 'risklist' ),
			'items_list_navigation' => __( 'Metrics list navigation', 'risklist' ),
			'filter_items_list'     => __( 'Filter Metrics list', 'risklist' ),
		);
		$args = array(
			'label'                 => __( 'Metrics', 'risklist' ),
			'description'           => __( 'Metrics', 'risklist' ),
			'labels'                => $labels,
			'supports'              => array(  'title','taxonomies', 'author', 'revisions', 'page-attributes'), #, 
			'hierarchical'          => false, 
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => $risklist_slugs['home'],
			'menu_position'         => "27",
			'menu_icon'             => 'dashicons-chart-line',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => false,
			'has_archive'           => false,		
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'taxonomies' 			=> array('risklist_metrics'),
						'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_post_type( 'risklist_metric', $args );


		


		$labels = array(
			'name'                       => _x( 'Control Type', 'Control Type', 'risklist' ),
			'singular_name'              => _x( 'Control Type', 'Control Type', 'risklist' ),
			'menu_name'                  => __( 'Control Types', 'risklist' ),
			'all_items'                  => __( 'All Tags', 'risklist' ),
			'parent_item'                => __( 'Parent Tag', 'risklist' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'risklist' ),
			'new_item_name'              => __( 'New Tag Name', 'risklist' ),
			'add_new_item'               => __( 'Add Tag Item', 'risklist' ),
			'edit_item'                  => __( 'Edit Tag', 'risklist' ),
			'update_item'                => __( 'Tag Item', 'risklist' ),
			'view_item'                  => __( 'View Tag', 'risklist' ),
			'separate_items_with_commas' => __( 'Separate Tags with commas', 'risklist' ),
			'add_or_remove_items'        => __( 'Add or remove Tags', 'risklist' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'risklist' ),
			'popular_items'              => __( 'Popular Tags', 'risklist' ),
			'search_items'               => __( 'Search Tags', 'risklist' ),
			'not_found'                  => __( 'Not Found', 'risklist' ),
			'no_terms'                   => __( 'No Tags', 'risklist' ),
			'items_list'                 => __( 'Tags list', 'risklist' ),
			'items_list_navigation'      => __( 'Tags list navigation', 'risklist' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
			'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_taxonomy( 'risklist_controltag', array( 'risklist_controltag' ), $args );

		$labels = array(
			'name'                       => _x( 'Control Status', 'Control Status', 'risklist' ),
			'singular_name'              => _x( 'Control Status', 'Control Status', 'risklist' ),
			'menu_name'                  => __( 'Control Status', 'risklist' ),
			'all_items'                  => __( 'All Tags', 'risklist' ),
			'parent_item'                => __( 'Parent Tag', 'risklist' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'risklist' ),
			'new_item_name'              => __( 'New Tag Name', 'risklist' ),
			'add_new_item'               => __( 'Add Tag Item', 'risklist' ),
			'edit_item'                  => __( 'Edit Tag', 'risklist' ),
			'update_item'                => __( 'Tag Item', 'risklist' ),
			'view_item'                  => __( 'View Tag', 'risklist' ),
			'separate_items_with_commas' => __( 'Separate Tags with commas', 'risklist' ),
			'add_or_remove_items'        => __( 'Add or remove Tags', 'risklist' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'risklist' ),
			'popular_items'              => __( 'Popular Tags', 'risklist' ),
			'search_items'               => __( 'Search Tags', 'risklist' ),
			'not_found'                  => __( 'Not Found', 'risklist' ),
			'no_terms'                   => __( 'No Tags', 'risklist' ),
			'items_list'                 => __( 'Tags list', 'risklist' ),
			'items_list_navigation'      => __( 'Tags list navigation', 'risklist' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
						'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_taxonomy( 'risklist_controlstate', array( 'risklist_controlstate' ), $args );

		$labels = array(
			'name'                  => _x( 'Controls', 'controls', 'risklist' ),
			'singular_name'         => _x( 'Control', 'control', 'risklist' ),
			'menu_name'             => __( 'Controls', 'risklist' ),
			'name_admin_bar'        => __( 'Control', 'risklist' ),
			'archives'              => __( 'Control Archives', 'risklist' ),
			'parent_item_colon'     => __( 'Control:', 'risklist' ),
			'parent'    			=> __( 'Control', 'risklist' ),
			'all_items'             => __( 'Controls', 'risklist' ),
			'add_new_item'          => __( 'Add New Control', 'risklist' ),
			'add_new'               => __( 'Add New', 'risklist' ),
			'new_item'              => __( 'New control', 'risklist' ),
			'edit_item'             => __( 'Edit control', 'risklist' ),
			'update_item'           => __( 'Update control', 'risklist' ),
			'view_item'             => __( 'View control', 'risklist' ),
			'search_items'          => __( 'Search control', 'risklist' ),
			'not_found'             => __( 'Not found', 'risklist' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'risklist' ),
			'featured_image'        => __( 'Control Image', 'risklist' ),
			'set_featured_image'    => __( 'Set control image', 'risklist' ),
			'remove_featured_image' => __( 'Remove control image', 'risklist' ),
			'use_featured_image'    => __( 'Use as control image', 'risklist' ),
			'insert_into_item'      => __( 'Insert into control', 'risklist' ),
			'uploaded_to_this_item' => __( 'Uploaded to this control', 'risklist' ),
			'items_list'            => __( 'controls list', 'risklist' ),
			'items_list_navigation' => __( 'controls list navigation', 'risklist' ),
			'filter_items_list'     => __( 'Filter controls list', 'risklist' ),
		);
		$args = array(
			'label'                 => __( 'Control', 'risklist' ),
			'description'           => __( 'Control', 'risklist' ),
			'labels'                => $labels,
			'supports'              => array(  'title','editor','taxonomies', 'author', 'revisions'), #, 'page-attributes'
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false, #risklist_getSetting('companylevelcustomers'), #} Will be true if b2b on
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => $risklist_slugs['home'],
			'menu_position'         => "10",
			'menu_icon'             => 'dashicons-shield',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => false,
			'has_archive'           => false,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'taxonomies' 			=> array('risklist_controltag'),
			'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_post_type( 'risklist_control', $args );

		$labels = array(
			'name'                  => _x( 'Processes', 'processs', 'risklist' ),
			'singular_name'         => _x( 'Process', 'process', 'risklist' ),
			'menu_name'             => __( 'Processes', 'risklist' ),
			'name_admin_bar'        => __( 'Process', 'risklist' ),
			'archives'              => __( 'Process Archives', 'risklist' ),
			'parent_item_colon'     => __( 'Process:', 'risklist' ),
			'parent'    			=> __( 'Process', 'risklist' ),
			'all_items'             => __( 'Processs', 'risklist' ),
			'add_new_item'          => __( 'Add New Process', 'risklist' ),
			'add_new'               => __( 'Add New', 'risklist' ),
			'new_item'              => __( 'New process', 'risklist' ),
			'edit_item'             => __( 'Edit process', 'risklist' ),
			'update_item'           => __( 'Update process', 'risklist' ),
			'view_item'             => __( 'View process', 'risklist' ),
			'search_items'          => __( 'Search process', 'risklist' ),
			'not_found'             => __( 'Not found', 'risklist' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'risklist' ),
			'featured_image'        => __( 'Process Image', 'risklist' ),
			'set_featured_image'    => __( 'Set process image', 'risklist' ),
			'remove_featured_image' => __( 'Remove process image', 'risklist' ),
			'use_featured_image'    => __( 'Use as process image', 'risklist' ),
			'insert_into_item'      => __( 'Insert into process', 'risklist' ),
			'uploaded_to_this_item' => __( 'Uploaded to this process', 'risklist' ),
			'items_list'            => __( 'processs list', 'risklist' ),
			'items_list_navigation' => __( 'processs list navigation', 'risklist' ),
			'filter_items_list'     => __( 'Filter processs list', 'risklist' ),
		);
		$args = array(
			'label'                 => __( 'Process', 'risklist' ),
			'description'           => __( 'Process', 'risklist' ),
			'labels'                => $labels,
			'supports'              => array(  'title','taxonomies', 'author'), #, 'page-attributes'
			'hierarchical'          => false, #risklist_getSetting('companylevelcustomers'), #} Will be true if b2b on
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => $risklist_slugs['home'],
			'menu_position'         => "10",
			'menu_icon'             => 'dashicons-backup',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => false,
			'has_archive'           => false,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_post_type( 'risklist_process', $args );

		

		$labels = array(
			'name'                       => _x( 'Action Tags', 'action Tags', 'risklist' ),
			'singular_name'              => _x( 'Action Tag', 'action Tag', 'risklist' ),
			'menu_name'                  => __( 'Action Tags', 'risklist' ),
			'all_items'                  => __( 'All Tags', 'risklist' ),
			'parent_item'                => __( 'Parent Tag', 'risklist' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'risklist' ),
			'new_item_name'              => __( 'New Tag Name', 'risklist' ),
			'add_new_item'               => __( 'Add Tag Item', 'risklist' ),
			'edit_item'                  => __( 'Edit Tag', 'risklist' ),
			'update_item'                => __( 'Tag Item', 'risklist' ),
			'view_item'                  => __( 'View Tag', 'risklist' ),
			'separate_items_with_commas' => __( 'Separate Tags with commas', 'risklist' ),
			'add_or_remove_items'        => __( 'Add or remove Tags', 'risklist' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'risklist' ),
			'popular_items'              => __( 'Popular Tags', 'risklist' ),
			'search_items'               => __( 'Search Tags', 'risklist' ),
			'not_found'                  => __( 'Not Found', 'risklist' ),
			'no_terms'                   => __( 'No Tags', 'risklist' ),
			'items_list'                 => __( 'Tags list', 'risklist' ),
			'items_list_navigation'      => __( 'Tags list navigation', 'risklist' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
						'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_taxonomy( 'risklist_actiontag', array( 'risklist_actiontag' ), $args );


		$labels = array(
			'name'                  => _x( 'Actions', 'actions', 'risklist' ),
			'singular_name'         => _x( 'Action', 'action', 'risklist' ),
			'menu_name'             => __( 'Actions', 'risklist' ),
			'name_admin_bar'        => __( 'Action', 'risklist' ),
			'archives'              => __( 'Action Archives', 'risklist' ),
			'parent_item_colon'     => __( 'Action:', 'risklist' ),
			'parent'    			=> __( 'Action', 'risklist' ),
			'all_items'             => __( 'Actions', 'risklist' ),
			'add_new_item'          => __( 'Add New action', 'risklist' ),
			'add_new'               => __( 'Add New', 'risklist' ),
			'new_item'              => __( 'New action', 'risklist' ),
			'edit_item'             => __( 'Edit action', 'risklist' ),
			'update_item'           => __( 'Update action', 'risklist' ),
			'view_item'             => __( 'View action', 'risklist' ),
			'search_items'          => __( 'Search action', 'risklist' ),
			'not_found'             => __( 'Not found', 'risklist' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'risklist' ),
			'featured_image'        => __( 'Action Image', 'risklist' ),
			'set_featured_image'    => __( 'Set action image', 'risklist' ),
			'remove_featured_image' => __( 'Remove action image', 'risklist' ),
			'use_featured_image'    => __( 'Use as action image', 'risklist' ),
			'insert_into_item'      => __( 'Insert into action', 'risklist' ),
			'uploaded_to_this_item' => __( 'Uploaded to this action', 'risklist' ),
			'items_list'            => __( 'actions list', 'risklist' ),
			'items_list_navigation' => __( 'actions list navigation', 'risklist' ),
			'filter_items_list'     => __( 'Filter actions list', 'risklist' ),
		);
		$args = array(
			'label'                 => __( 'Action', 'risklist' ),
			'description'           => __( 'Action', 'risklist' ),
			'labels'                => $labels,
			'supports'              => array(  'title','editor','taxonomies', 'author', 'revisions'), #, 'page-attributes'
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false, #actionlist_getSetting('companylevelcustomers'), #} Will be true if b2b on
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => $risklist_slugs['home'],
			'menu_position'         => "25.3",
			'menu_icon'             => 'dashicons-warning',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => false,
			'has_archive'           => false,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'taxonomies' 			=> array('risklist_actiontag'),
			'capabilities' => array(
		        'edit_post' => 'manage_risks',
		        'edit_posts' => 'manage_risks',
		        'edit_others_posts' => 'manage_risks',
		        'publish_posts' => 'manage_risks',
		        'read_post' => 'manage_risks',
		        'read_private_posts' => 'manage_risks',
		        'delete_post' => 'manage_risks'
		    )
		);
		register_post_type( 'risklist_action', $args );


}

/* ======================================================
	/ Custom Post Types
   ====================================================== */


define('RISKLIST_INC_CPT',true);

?>