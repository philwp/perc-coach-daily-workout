<?php

namespace perccoach\dailyworkout\workout;

use perccoach\dailyworkout\meta;
use perccoach\dailyworkout\start;


class workouts {

	/**
	 * @var \WP_Query
	 */
	protected $query;

	protected $workouts;
	/**
	 * workouts constructor.
	 *
	 * @param int $total Total number of workouts to find
	 * @param array $metas Values for meta to search by
	 */
	public function __construct( $total, $metas = [] ) {
		$metas = $this->prepare_meta( $metas );
		$meta_query = $this->prepare_meta_query( $metas );
		$this->query( $total, $meta_query );
	}

	/**
	 * Get found workouts
	 *
	 * @return array
	 */
	public function get_workouts(){
				if( ! isset( $this->workouts ) && isset( $this->query ) && 0 < $this->get_total_found() ){
			$this->populate_workouts_array();

		}

		if( ! isset( $this->workouts ) ){
			$this->workouts = [];
		}

		return $this->workouts;

	}

	/**
	 * Get the total number of found workouts
	 *
	 * @return int
	 */
	public function get_total_found(){
		return $this->query->found_posts;
	}

	/**
	 * Prepare meta values making sure they are valid
	 *
	 * @param array $metas
	 *
	 * @return array
	 */
	protected function prepare_meta( $metas ){
		$prepared =  array_fill_keys( [
			meta::EXERCISES,
		], '');
		if( empty( $metas ) ){
			return $prepared;
		}

		foreach( array_keys( $prepared ) as $key ){
			if ( isset( $metas[ $key ] ) && ( is_string( $metas[ $key ] ) || is_numeric( $metas[ $key ] ) ) ) {
				$prepared[ $key ] = strip_tags( $metas[ $key ] );
			}
		}

		return $prepared;
	}

	/**
	 * Populate the workouts property by converting posts from query to workout objects
	 */
	protected function populate_workouts_array() {
		$workouts = $this->query->posts;
		foreach ( $workouts as $workout ) {
			$this->workouts[] = factory::post_to_workout( $workout );
		}
	}


}
