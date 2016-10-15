<?php

namespace perccoach\dailyworkout;

class exercise extends singular {

	/**
	 * @var int
	 */
	protected $sheet_music;


	/**
	 * @var array
	 */
	protected $audio;




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

	public function save(){

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
