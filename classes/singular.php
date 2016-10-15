<?php

namespace perccoach\dailyworkout;


abstract class singular {

	 /**
	 * workout constructor.
	 *
	 * @param int $id Optional. Pass ID to retrive from DB, else use setters
	 */
	public function __construct( $id = 0 ) {
		if( 0 < absint( $id ) ){
			$this->get_from_db( $id );
		}
	}

	public function get_id(){
		if( isset( $this->post ) ){
			return $this->post->ID;
		}

		return false;
	}

	/**
	 * Delete item
	 *
	 * @return bool
	 */
	public function delete(){
		if ( isset( $this->post ) ) {
			$deleted = wp_delete_post( $this->post->ID );
			if( false == $deleted ){
				return false;
			}else{
				return true;
			}
		}

		return false;
	}

	/**
	 * Set the title
	 *
	 * @param string $title
	 *
	 * @return bool
	 */
	public function set_title( $title ){
		if( is_string( $this->title ) ){
			$this->title = $title;
			return true;
		}


		return false;
	}


}
