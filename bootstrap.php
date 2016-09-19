<?php

/**
 * Register Autoloader
 */
spl_autoload_register(function ($class) {
	$prefix = 'perccoach\\dailyworkout\\';
	$base_dir = __DIR__ . '/classes/';
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		return;
	}
	$relative_class = substr($class, $len);
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
	if (file_exists($file)) {
		require $file;
	}

});

/**
 * Go!
 */
add_action( 'init', 'perc_coach_daily_workout_register_cpt', 0 );
add_action( 'init', 'perc_coach_daily_workout_load_cmb2', 2 );
//will run main class here shortly
//

/**
 * Add Book
 */
// Register Custom Book
function perc_coach_daily_workout_register_cpt() {

	$labels = array(
		'name'                  => _x( 'Workouts', 'Workout General Name', 'perc-coach-daily-workout' ),
		'singular_name'         => _x( 'Workout', 'Workout Singular Name', 'perc-coach-daily-workout' ),
		'menu_name'             => __( 'Workouts', 'perc-coach-daily-workout' ),
		'name_admin_bar'        => __( 'Workout', 'perc-coach-daily-workout' ),
		'archives'              => __( 'Item Archives', 'perc-coach-daily-workout' ),
		'parent_item_colon'     => __( 'Parent Item:', 'perc-coach-daily-workout' ),
		'all_items'             => __( 'All Items', 'perc-coach-daily-workout' ),
		'add_new_item'          => __( 'Add New Item', 'perc-coach-daily-workout' ),
		'add_new'               => __( 'Add New', 'perc-coach-daily-workout' ),
		'new_item'              => __( 'New Item', 'perc-coach-daily-workout' ),
		'edit_item'             => __( 'Edit Item', 'perc-coach-daily-workout' ),
		'update_item'           => __( 'Update Item', 'perc-coach-daily-workout' ),
		'view_item'             => __( 'View Item', 'perc-coach-daily-workout' ),
		'search_items'          => __( 'Search Item', 'perc-coach-daily-workout' ),
		'not_found'             => __( 'Not found', 'perc-coach-daily-workout' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'perc-coach-daily-workout' ),
		'featured_image'        => __( 'Featured Image', 'perc-coach-daily-workout' ),
		'set_featured_image'    => __( 'Set featured image', 'perc-coach-daily-workout' ),
		'remove_featured_image' => __( 'Remove featured image', 'perc-coach-daily-workout' ),
		'use_featured_image'    => __( 'Use as featured image', 'perc-coach-daily-workout' ),
		'insert_into_item'      => __( 'Insert into item', 'perc-coach-daily-workout' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'perc-coach-daily-workout' ),
		'items_list'            => __( 'Items list', 'perc-coach-daily-workout' ),
		'items_list_navigation' => __( 'Items list navigation', 'perc-coach-daily-workout' ),
		'filter_items_list'     => __( 'Filter items list', 'perc-coach-daily-workout' ),
	);
	$args = array(
		'label'                 => __( 'Workout', 'perc-coach-daily-workout' ),
		'description'           => __( 'Workout Description', 'perc-coach-daily-workout' ),
		'labels'                => $labels,
		'supports'              => array( ),
		'taxonomies'            => array( 'category', 'post_tag' ),
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
		'capability_type'       => 'page',
	);
	register_post_type( 'post_type', $args );

}

/**
 * Load CMB2
 *
 * @since 0.0.1
 *
 * @uses init
 */
function perc_coach_daily_workout_load_cmb2(){
	include_once  __DIR__ . '/includes/cmb2/init.php';
}

