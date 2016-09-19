<?php
/*
  Plugin Name: Percussion Coach Daily Workout
  Version: 0.0.1
  License: GPL V2
  Text Domain: learnjosh-book-review
  Domain Path: /languages
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PERC_COACH_DAILY_WORKOUT_PATH', dirname( __FILE__ ) );
define( 'PERC_COACH_DAILY_WORKOUT_URL', plugin_dir_url(__FILE__ ) );

/**
 * Hooks to setup plugin
 */
add_action( 'plugins_loaded', 'perc_coach_daily_workout_notice_load_plugin_textdomain' );
add_action( 'plugins_loaded', 'perc_coach_daily_workout_bootstrap', 25 );

/**
 * Load plugin or throw notice
 *
 * @uses plugins_loaded
 */
function perc_coach_daily_workout_bootstrap(){
	global $wp_version;
	$php_check = version_compare( PHP_VERSION, '5.4.0', '>=' );
	$wp_check = version_compare( $wp_version, '4.2', '>=' );
	if ( ! $php_check  || !  $wp_check ) {
		function perc_coach_daily_workout_notice() {
			global $pagenow;
			if( 'plugins.php' !== $pagenow ) {
				return;
			}
			?>
			<div class="notice notice-error">
				<p><?php _e( 'Percussion Coach Daily Workout requires PHP 5.4 or later. Please update your PHP.', 'perc-coach-daily-workout' ); ?></p>
			</div>
			<?php
		}
		add_action( 'admin_notices', 'perc_coach_daily_workout_notice' );

	}else{
		//bootstrap plugin
		require_once( dirname( __FILE__ ) . '/bootstrap.php' );

	}

}

/**
 * Loads the text domain for translation
 */
function perc_coach_daily_workout_notice_load_plugin_textdomain() {
	load_plugin_textdomain( 'perc-coach-daily-workout', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
}




