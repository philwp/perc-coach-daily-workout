<?php


namespace perccoach\dailyworkout;

use perccoach\dailyworkout\singular;
use perccoach\dailyworkout\meta;
use perccoach\dailyworkout\start;

class workout extends singular {


	/**
	 * @var array
	 */
	protected $exercises;


	/**
	 * Set properties by querying DB
	 *
	 * @param int $id Workout ID
	 */
	protected function get_from_db( $id ){
		$this->post = get_post( $id );
		if( ! empty( $this->post ) ){
			$this->set_exercises( get_post_meta( $this->post->ID, meta::EXERCISES ) );

			$this->title = $this->post->post_title;
			$this->content = $this->post->post_content;
		}

	}

	/**
	 * Save workout in DB
	 *
	 * @return bool|int False if not saved, ID if saved
	 */
	public function save(){
		$args = [
			'post_title' => $this->title,
			'post_content' => $this->content,
			'post_type' => start::$POST_TYPES[0]
		];

		if( isset( $this->post ) && isset( $this->post->ID ) ){
			$args[ 'ID' ] = $this->post->ID;
			$args[ 'post_status' ] = 'publish';
		}

		$id = wp_update_post( $args );
		if( is_numeric( $id ) ){
			update_post_meta( $id, meta::EXERCISES, $this->exercises );
			$this->get_from_db( $id );
			return  $id;
		}else{
			return false;
		}
	}


	/**
	 * Get the exercises
	 *
	 * @return array
	 */
	public function get_exercises(){
		return $this->exercises;
	}

	/**
	 * Set the exercises
	 *
	 * @param stri
	 *
	 * @return bool
	 */
	public function set_exercises( $exercises ){
		if( is_array( $exercises ) ){
			$this->exercises = $exercises;
			return true;
		}

		return false;

	}


	/**
	 * Get current values as
	 *
	 * @return array
	 */
	public function to_array(){
		$data = [];
		foreach( get_object_vars( $this ) as $prop => $value ){
			if( 'post' != $prop ) {
				$data[ $prop ] = $value;
			}

		}

		$data[ 'ID' ] = $this->post->ID;
		//$data[ 'cover' ] = $this->get_cover_url();
		$data[ 'link' ] = get_permalink( $this->post );

	 	return $data;
	}

}
