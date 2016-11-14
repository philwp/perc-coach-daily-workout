<?php

namespace perccoach\dailyworkout\admin;

use perccoach\dailyworkout\meta;
use perccoach\dailyworkout\start;

class editor {
	/**
	 * @var \CMB2
	 */
	protected $cmb2_workout;

	/**
	 * @var \CMB2
	 */
	protected $cmb2_exercise;

	/**
	 * Run system
	 *
	 * @since 0.0.1
	 */
	public function run(){
		$this->make_boxes();
		$this->add_fields();

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
		        'url' => false,
		    ),
		    'text'    => array(
		        'add_upload_file_text' => 'Add File'
		    ),
		) );

		$main_section = $this->cmb2_exercise->add_field([
			'id'          => meta::SECTION1,
    		'type'        => 'group',
    		'description' => __( 'Enter tracks for exercise', 'cmb2' ),
		    'options'     => array(
		        'group_title'   => __( 'Track {#}', 'cmb2' ),
		        'add_button'    => __( 'Add Another Track', 'cmb2' ),
		        'remove_button' => __( 'Remove Track', 'cmb2' ),
		        'sortable'      => true
    		),

		]);

		$this->cmb2_exercise->add_group_field( meta::SECTION1, [
			'name'       => __( 'Audio URL', 'perc-coach-daily-workout' ),
			'desc'       => __( 'URL of tempo', 'perc-coach-daily-workout' ),
			'id'         => meta::AUDIO,
			'repeatable' => false,
			'type'       => 'file',
			'options' => array(
		        'url' => false,
		    ),
		    'text'    => array(
		        'add_upload_file_text' => 'Add Audio File'
		    ),

		]);
		$this->cmb2_exercise->add_group_field( meta::SECTION1, array(
		    'name'    => 'Tempo',
		    'id'      => meta::TEMPO,
		    'type'    => 'text_small'
		) );


		$this->cmb2_workout->add_field( array(
		    'name'             => 'Exercise',
		    'desc'             => 'Select an exercise',
		    'id'               => meta::EXERCISES,
		    'type'             => 'select',
		    'show_option_none' => true,
		    'default'          => 'custom',
		    'repeatable'	   => true,
		    'options'          => $this->available_exercises( start::$POST_TYPES[1] ),

		) );

	}

	protected function available_exercises( $post_type ) {
		$args = [
			'post_type' => $post_type,
			'numberposts' => -1
		];
		$available_exercises = get_posts( $args );
		$exercise_array = [];

		foreach ( $available_exercises as $exercise ) {

			$exercise_array[ $exercise->ID ] = $exercise->post_title;

		}

		return $exercise_array;

	}

}
