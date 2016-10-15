<?php

namespace perccoach\dailyworkout\api\responses;

class response  extends \WP_REST_Response{


	public function __construct( $data = null, $status = 200, $headers = array() ) {
		parent::__construct( $data, $status, $headers );
		if( empty( $data ) ){
			$this->set_status( 404 );
		}

	}

	/**
	 * Set a total for total number of workouts in response
	 *
	 * @param int $total
	 */
	public function set_total_header( $total ){
		$this->header( 'X-WP-Total', (int) $total );
	}
}
