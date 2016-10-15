<?php

namespace perccoach\dailyworkout;

use perccoach\dailyworkout\workout;

class factory {

	/**
	 * Utility method to turn a WP_Post object into object of workout class
	 *
	 * @param \WP_Post $post
	 *
	 * @return workout
	 */
	public static function post_to_workout( \WP_Post $post ){
		$workout = new workout( $post->ID );
		return $workout;
	}

	/**
	 * Utility method to turn a WP_Post object into object of exercise class
	 *
	 * @param \WP_Post $post
	 *
	 * @return exercise
	 */
	public static function post_to_exercise( \WP_Post $post ){
		$exercise = new exercise( $post->ID );
		return $exercise;
	}


}
