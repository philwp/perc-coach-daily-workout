<?php

namespace perccoach\dailyworkout;

use perccoach\dailyworkout\meta;
use perccoach\dailyworkout\start;


class workouts {

	/**
	 * @var \WP_Query
	 */
	protected $query;

	/**
	 * @var array
	 */
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
	public function get_workouts( $to_array = true ){
				if( ! isset( $this->workouts ) && isset( $this->query ) && 0 < $this->get_total_found() ){
			$this->populate_workouts_array();

		}

		if( ! isset( $this->workouts ) ){
			$this->workouts = [];
		}

				if( ! empty( $this->workouts ) ){
			$as_arrays = [];
			foreach( $this->workouts as $workout ){
				$as_arrays[] = $workout->to_array();
			}

			return $as_arrays;
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
	 * Construct a meta query
	 *
	 * @param array $metas
	 *
	 * @return array
	 */
	protected function prepare_meta_query( $metas ){
		$meta_query = [];
		foreach( $metas as $key => $value ){
			if( ! empty( $value ) ){
				$meta_query[] = [
					'key'     => $key,
					'value'   => $value,
					'compare' => 'LIKE',
				];
			}
		}

		return $meta_query;


	}

	/**
	 * Get books using WP_Query
	 *
	 * @param int $total Total number of workouts to query for
	 * @param array $meta_query Optional meta query.
	 */
	protected function query( $total, $meta_query = [] ){
		$args = [
			'post_type' => start::$POST_TYPES[0],
			'post_per_page' => $total
		];
		if( ! empty( $meta_query ) ){
			$args ['meta_query' ] = [ $meta_query ];
		}

		$this->query = new \WP_Query( $args );
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
