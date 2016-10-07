<?php

//create a workout from a group of one or more exersices
//
//  Title
//  Exercises


namespace perccoach\dailyworkout\workout;

class workout {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $content;

	/**
	 * @var array
	 */
	protected $exercises;

	/**
	 * @var \WP_Post
	 */
	protected $post;


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
	 * Delete workout
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

	/**
	 * Get the exrcises
	 *
	 * @return array
	 */
	public function get_exercises(){
		return $this->exercises;
	}


}
