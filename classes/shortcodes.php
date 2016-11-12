<?php

namespace perccoach\dailyworkout;

use perccoach\dailyworkout\meta;

class shortcodes {

	public function register() {

		add_shortcode( meta::SHORTCODE, [ $this, 'main_workout_output' ] );

	}

	public function main_workout_output( $atts ) {

		$a = shortcode_atts( ['id' => null ], $atts );

		if  ( ! is_null( $a[ 'id' ] ) ) {
			return '<div id="dailyworkout-wrapper" data-dwid="' . $a['id'] . '"><div id="dailyworkout"></div></div>';
		}



	}
}
