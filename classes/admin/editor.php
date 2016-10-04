<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 9/13/16
 * Time: 7:25 PM
 */

namespace perccoach\dailyworkout\admin;


use perccoach\dailyworkout\meta;
use perccoach\dailyworkout\start;

class editor {
	/**
	 * @var \CMB2
	 */
	protected $cmb2_workout;
	protected $cmb2_exercise;

	/**
	 * Run system
	 *
	 * @since 0.0.1
	 */
	public function run(){
		$this->make_boxes();
		$this->add_fields();
		$this->run_ajax();
	}


	public function load_scripts() {
		wp_enqueue_script( 'pw_dw_cmb', plugins_url( '../../assets/js/pc-dw-cmb.js', __FILE__ ), array( 'jquery' ), 1, true );


	}

	/**
	 * Create metabox object
	 *
	 * @since 0.0.1
	 */
	protected function make_boxes( ){
		$this->cmb2_workout = new_cmb2_box( [
			'id'            => start::$SLUG[0],
			'title'         => __( 'Daily Workout', 'perc-coach-daily-workout' ),
			'object_types'  => array( start::$POST_TYPES[0] ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
		]);

		$this->cmb2_exercise = new_cmb2_box( [
			'id'            => start::$SLUG[1],
			'title'         => __( 'Exercise', 'perc-coach-daily-workout' ),
			'object_types'  => array( start::$POST_TYPES[1] ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
		]);
	}

	/**
	 * Add fields to box
	 */
	protected function add_fields(){

		//Meta box for Exercise

		$this->cmb2_exercise->add_field( array(
    		'name'    => 'Music Image',
    		'desc'    => 'Upload an image.',
    		'id'      => meta::SHEET_MUSIC,
    		'type'    => 'file',
		    'options' => array(
		        'url' => false, // Hide the text input for the url
		    ),
		    'text'    => array(
		        'add_upload_file_text' => 'Add File' // Change upload button text.
		    ),
		) );

		$main_section = $this->cmb2_exercise->add_field([
			'id'          => meta::SECTION1,
    		'type'        => 'group',
    		'description' => __( 'Enter tracks for exercise', 'cmb2' ),
    		// 'repeatable'  => false, // use false if you want non-repeatable group
		    'options'     => array(
		        'group_title'   => __( 'Track {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
		        'add_button'    => __( 'Add Another Track', 'cmb2' ),
		        'remove_button' => __( 'Remove Track', 'cmb2' ),
		        'sortable'      => true, // beta
		        // 'closed'     => true, // true to have the groups closed by default
    		),

		]);

		$this->cmb2_exercise->add_group_field( meta::SECTION1, [
			'name'       => __( 'Audio URL', 'perc-coach-daily-workout' ),
			'desc'       => __( 'URL of tempo', 'perc-coach-daily-workout' ),
			'id'         => meta::AUDIO,
			'repeatable' => false,
			'type'       => 'file',
			'options' => array(
		        'url' => false, // Hide the text input for the url
		    ),
		    'text'    => array(
		        'add_upload_file_text' => 'Add Audio File' // Change upload button text.
		    ),

		]);
		$this->cmb2_exercise->add_group_field( meta::SECTION1, array(
		    'name'    => 'Tempo',
		    //'desc'    => 'field description (optional)',
		    //'default' => 'standard value (optional)',
		    'id'      => meta::TEMPO,
		    'type'    => 'text_small'
		) );

	// Metabox for Workout

		$main_section = $this->cmb2_workout->add_field([
			'id'          => meta::SECTION2,
    		'type'        => 'group',
    		'description' => __( 'Enter exercises for daily workout', 'cmb2' ),
    		// 'repeatable'  => false, // use false if you want non-repeatable group
		    'options'     => array(
		        'group_title'   => __( 'Exercise {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
		        'add_button'    => __( 'Add Another Exercise', 'cmb2' ),
		        'remove_button' => __( 'Remove Exercise', 'cmb2' ),
		        'sortable'      => true, // beta
		        // 'closed'     => true, // true to have the groups closed by default
    		),
		]);


		$available_exercises = get_posts( array( 'post_type' => 'pc_dw_exercise' ) );
		$exercise_array = [];

		foreach ($available_exercises as $exercise) {

			$exercise_array[$exercise->ID] = $exercise->post_title;

		}


		$this->cmb2_workout->add_group_field( meta::SECTION2, array(
		    'name'             => 'Name',
		    'desc'             => 'Select an exercise',
		    'id'               => 'exercise_select',
		    'type'             => 'select',
		    'show_option_none' => true,
		    'default'          => 'custom',
		    'options'          => $exercise_array,

		) );

		$this->cmb2_workout->add_group_field( meta::SECTION2, array(
		    'name'    => 'Test Multi Checkbox',
		    'desc'    => 'field description (optional)',
		    'id'      => 'wiki_test_multicheckbox',
		    'type'    => 'multicheck',
		    'options' => $this->set_options(),
		) );

	}

	public function ajax_process_request() {
	// first check if data is being sent and that it is the data we want
  	if ( isset( $_POST["post_var"] ) ) {
		// now set our response var equal to that of the POST var (this will need to be sanitized based on what you're doing with with it)
		$post_id = $_POST["post_var"];

		$meta_array = get_post_meta( $post_id, 'pcdw_section1' );
		$sections = $meta_array[0];
		//var_dump($sections);
		$response = [];
		foreach( $sections as $section ) {
		 	$response[ $section[ 'pcdw_audio_id' ] ] = $section[ 'pcdw_tempo' ];
			//var_dump($section[pcdw_audio_id]);
		 }

		var_dump($response);
		// send the response back to the front end
		echo $response;
		wp_die();
	}
}

	private function run_ajax() {
		add_action('wp_ajax_test_response', $this->return_tempos() );

	}


	private function set_options() {
		global $post;

		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : false;
		if( false == $post_id && isset( $post->ID )){
			$post_id = $post->ID;
		}
		return $this->get_tempos( $post_id );
	}

	public function get_tempos( $exercise = '' ) {
		if ( empty( $exercise ) ) {
			return '';
		}
		$meta_array = get_post_meta( $post_id, 'pcdw_section1' );
		$sections = $meta_array[0];
		$tempos = [];
		foreach( $sections as $section ) {
		 	$tempos[ $section[ 'pcdw_audio_id' ] ] = $section[ 'pcdw_tempo' ];
		 }
		return $tempos;
		//wp_die();
	}

	public function return_tempos() {
		global $post;
		$value = $_POST["post_var"];
		$safe_value = esc_attr( $value );
		$tempos = $this->get_tempos( $safe_value );
		// $tempos = array(
		// 	2 => 2,
		// 	3 => 3);
		if( ! $tempos ){
			wp_send_json_error( array( 'msg' => 'Value inaccessible') );
		}
		$output = '';
		foreach( $tempos as $tempo => $tempo_id ){
			$output .= sprintf( "<option value='%s'>%s</option>", $tempo, $tempo_id );
		 }
		if( ! empty( $output ) ){
			wp_send_json_success( $output );
		}
		wp_send_json_error();
		wp_die( );
	}
}
