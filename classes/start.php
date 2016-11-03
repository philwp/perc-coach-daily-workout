<?php


namespace perccoach\dailyworkout;

use perccoach\dailyworkout\admin\editor;
use perccoach\dailyworkout\apimeta;



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


	protected $editor;

	protected $api_meta;


	public function __construct() {
		if( is_admin() ){
			$this->start_admin();
		}

		$this->add_api_meta();

	}

	protected function start_admin(){
		$this->add_cmb2();
	}


	protected function add_cmb2(){
		$this->editor = new editor();
		add_action( 'cmb2_admin_init', [ $this->editor, 'run' ] );
	}

	protected function add_api_meta() {
		$this->api_meta = new apimeta();
		add_action( 'rest_api_init', [ $this->api_meta, 'run' ] );
	}


}
