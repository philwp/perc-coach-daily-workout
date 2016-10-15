<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 9/14/16
 * Time: 8:10 PM
 */

namespace perccoach\dailyworkout\api\routes;


use perccoach\dailyworkout\api\responses\error;
use perccoach\dailyworkout\api\responses\response;
use perccoach\dailyworkout\workout;
//use perccoach\dailyworkout\workout\workouts;
use perccoach\dailyworkout\crud;
use perccoach\dailyworkout\meta;

class workouts extends public_route {


	/**
	 * @inheritdoc
	 */
	public function request_args() {
		return [

			'title' => [
				'required' => false,
				'sanitize_callback' =>[ $this, 'clean_string' ]
			],
			'content' => [
				'required' => false,
				'sanitize_callback' =>[ $this, 'clean_string' ]
			],
			'exercises' => [
				'required' => false,
				'sanitize_callback' =>[ $this, 'clean_string' ]
			],
			'number' => [
				'required' => false,
				'sanitize_callback' => 'absint',
				'default' => 10
			],
		];

	}

	public function create_item( \WP_REST_Request $request ) {
		$workout  = $this->setup_workout_object( $request, 0 );
		$saved = crud::create( $workout );
		if( $saved ){
			return new response( $workout->to_array(), 201 );
		}else{
			return new error( 400, __( 'Could not create new workout', 'perc-coach-daily-workout' ) );
		}

	}

	public function get_item( \WP_REST_Request $request ){
		$workout = crud::read( $request[ 'id' ] );
		if( ! empty( $workout ) ){
			return new response( $workout->to_array() );
		}else{
			return $this->not_found_error();
		}
	}

	public function update_item( \WP_REST_Request $request ) {
		$workout = $this->setup_workout_object( $request, $request[ 'id' ] );
		$saved = crud::create( $workout );
		if( $saved ){
			return new response( $workout->to_array(), 200 );
		}else{
			return $this->not_found_error();
		}
	}

	public function get_items( \WP_REST_Request $request ){
		$workouts = new \perccoach\dailyworkout\workouts($request[ 'number' ], [
			meta::EXERCISES => $request[ 'exercises' ],

		] );
		$found = $workouts->get_workouts();
		if( ! empty( $workouts ) ){
			$response = new response( $found, 200 );
			$response->set_total_header( $workouts->get_total_found() );
			return $response;
		}else{
			return $this->not_found_error();
		}

	}

	public function delete_item( \WP_REST_Request $request ) {
		$deleted = crud::delete( $request[ 'id' ] );
		if( $deleted ){
			return new response( __( 'Deleted' ), 204  );
		}else{
			return new error( 400, __( 'Could not delete', 'perc-coach-daily-workout' ) );
		}
	}

	/**
	 * @param \WP_REST_Request $request
	 *
	 * @return workout
	 */
	protected function setup_workout_object( \WP_REST_Request $request, $id ) {
		$workout = new workout( $id );
		$workout->set_title( $request[ 'title' ] );
		$workout->set_content( $request[ 'content' ] );


		return $workout;
	}

	/**
	 * @return error
	 */
	protected function not_found_error() {
		return new error( 404, __( 'Not found', 'perc-coach-daily-workout' ) );
	}

}
