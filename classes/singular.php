<?php

namespace perccoach\dailyworkout;


abstract class singular {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $content;

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

	public function get_id(){
		if( isset( $this->post ) ){
			return $this->post->ID;
		}

		return false;
	}

	abstract protected function get_from_db( $id );
		//include getters for meta here in child classes


	abstract function save();
		//include seeters for meta here in child classes



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

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function get_title(){
		return $this->title;
	}

	/**
	 * Set  content
	 *
	 * @param  string $content
	 *
	 * @return bool
	 */
	public function set_content( $content ){
		if( is_string( $content ) ){
			$this->content = $content;
			return true;
		}

		return false;
	}

	/**
	 * @return string
	 */
	public function get_content(){
		return $this->content;
	}



}
