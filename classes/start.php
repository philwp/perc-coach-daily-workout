<?php


namespace perccoach\dailyworkout;

use perccoach\dailyworkout\admin\editor;
use perccoach\dailyworkout\api\boot;
use perccoach\dailyworkout\api\routes\workouts;


class start {

	/**
	 * Defines the plugin's slug for use elsewhere
	 *
	 * @since 0.0.1
	 */
	public static $SLUG = array( 'pc-daily-workout', 'pc-daily-exercise' );

	/**
	 * Defines the post type's names
	 *
	 * @since 0.0.1
	 */
	public static $POST_TYPES = array( 'pc_dw_workout', 'pc_dw_exercise' );

	const API_NAMESPACE = 'daily-workout-api/v1';

	protected $editor;


	public function __construct() {
		if( is_admin() ){
			$this->start_admin();
		}

		add_action( 'rest_api_init', [ $this, 'boot_api' ] );
	}

	protected function start_admin(){
		$this->add_cmb2();
	}


	protected function add_cmb2(){
		$this->editor = new editor();
		add_action( 'cmb2_admin_init', [ $this->editor, 'run' ] );
	}

	/**
	 * Boot up API
	 *
	 * @uses "rest_api_init"
	 */
	public function boot_api(){
		$api = new boot( self::API_NAMESPACE );
		$api->add_route( new workouts() );
		$api->add_routes();
	}

}
