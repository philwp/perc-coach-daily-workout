<?php

namespace perccoach\dailyworkout;

class crud {

	/**
	 * Save a workout
	 *
	 * @param workout $workout Workout object
	 *
	 * @return bool|int
	 */
	public static function create( workout $workout ){
		return $workout->save();
	}

	/**
	 * Get a workout object, by ID
	 *
	 * @param int $id Workout ID
	 *
	 * @return workout
	 */
	public static function read( $id ){
		$workout = new workout( $id );
		return $workout;
	}

	public static function update( workout $workout ){
		return $workout->save();
	}

	public static function delete( $id ){
		$workout = new workout( $id );
		return $workout->delete();
	}

}
