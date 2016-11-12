<?php

namespace perccoach\dailyworkout;

use perccoach\dailyworkout\start;

class scripts {

	/**
	 * Current plugin version
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Url for assets dir
	 *
	 * @var string
	 */
	protected $url;

	public function __construct( $url, $version ) {
		$this->version = $version;
		$this->url = $url;
		$this->register();
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ], 1 );

	}

	/**
	 * Register scripts
	 *
	 * @uses wp_enqueue_scripts
	 */
	public  function register(){
		//wp_register_style( start::SLUG . '-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', '3.3.7' );
		//wp_register_style( start::SLUG, $this->url . 'css/book-reviews-ui.css', [ start::SLUG . '-bootstrap' ], $this->version );

		wp_register_script( 'dailyworkoutJS', $this->url . 'index.js', ['jquery'], $this->version, true  );
	}

	/**
	 * Enqueue Scripts
	 */
	public  function enqueue( $id = 0 ){
		wp_enqueue_script( 'dailyworkoutJS' );
		//wp_enqueue_style( start::SLUG );

	}
}
