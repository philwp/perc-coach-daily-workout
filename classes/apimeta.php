<?php


namespace perccoach\dailyworkout;

use \perccoach\dailyworkout\start;
use \perccoach\dailyworkout\meta;

class apimeta {

	public function run() {
		$this->add_rest_meta();
	}


	protected function add_rest_meta(){

		register_api_field( start::$POST_TYPES[0],
    		'exercises_ids',
		    array(
		       'get_callback'    => [ $this, 'get_exercises_ids_cb' ],
		       'update_callback' => null,
		       'schema'          => null,
		    )
		 );

		register_api_field( start::$POST_TYPES[0],
    		'exercises',
		    array(
		       'get_callback'    => [ $this, 'get_exercises_cb' ],
		       'update_callback' => null,
		       'schema'          => null,
		    )
		 );

		register_api_field( start::$POST_TYPES[1],
    		'sheet_music',
		    array(
		       'get_callback'    => [ $this, 'get_sheet_music_cb' ],
		       'update_callback' => null,
		       'schema'          => null,
		    )
		 );

		register_api_field( start::$POST_TYPES[1],
    		'sections',
		    array(
		       'get_callback'    => [ $this, 'get_sections_cb' ],
		       'update_callback' => null,
		       'schema'          => null,
		    )
		 );

	}


	/**
	 * Get the exercises ids
	 *
	 * @param $object, $field_name, $request
	 *
	 * @return array
	 */
	public function get_exercises_ids_cb( $object, $field_name, $request ) {

		return get_post_meta( $object[ 'id' ], meta::EXERCISES, true );
	}

	public function get_exercises_cb( $object, $field_name, $request ) {
		$exercise_title = get_the_title( $object[ 'id' ] );
		$exercises = get_post_meta( $object[ 'id' ], meta::EXERCISES, true );
		$return_array = [];

		$i = 0;
		foreach ($exercises as $exercise) {
			$exercise_title = get_the_title( $exercise );
			$exercise_array = [];
			$exercise_array[ 'title' ] = get_the_title( $exercise );
			$exercise_array[ 'sheet_music' ] = get_post_meta( $exercise, meta::SHEET_MUSIC, true );
			$exercise_array[ 'tracks' ] = get_post_meta( $exercise, meta::SECTION1, true );
			$return_array[ 'exercise_' . $i ] = $exercise_array;
			$i++;
		}


		return $return_array;
	}

	/**
	 * Get the sheet music URL
	 *
	 * @param $object, $field_name, $request
	 *
	 * @return string
	 */
	public function get_sheet_music_cb( $object, $field_name, $request ) {

		return get_post_meta( $object[ 'id' ], meta::SHEET_MUSIC, true );
	}

	/**
	 * Get the sections
	 *
	 * @param $object, $field_name, $request
	 *
	 * @return array
	 */
	public function get_sections_cb( $object, $field_name, $request ) {

		return get_post_meta( $object[ 'id' ], meta::SECTION1 );
	}

}
