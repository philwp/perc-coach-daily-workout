<?php

namespace perccoach\dailyworkout;

class exercise {

	/**
	 * @var int
	 */
	protected $sheet_music;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var array
	 */
	protected $audio;
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
	 * exercise constructor.
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
	 * @param int $id Exercise ID
	 */
	protected function get_from_db( $id ){
		$this->post = get_post( $id );
		if( ! empty( $this->post ) ){
			$this->set_sheet_music( get_post_meta( $this->post->ID, meta::SHEET_MUSIC ) );
			$this->set_audio( get_post_meta( $this->post->ID, meta::AUDIO ) );

		}

	}


	/**
	 * Set the sheet music
	 *
	 * @param int $id Cover image ID
	 *
	 * @return bool
	 */
	public function set_sheet_music( $id ){
		if( is_numeric( $id ) ){
			$this->sheetmusic = $id;
			return true;
		}

		return false;

	}

	/**
	 * Set the audio
	 *
	 * @param array
	 *
	 * @return bool
	 */
	public function set_audio( $audio ){
		if( is_array( $audio ) ){
			$this->audio = $audio;
			return true;
		}

		return false;
	}
}
