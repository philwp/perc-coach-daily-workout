<?php

namespace perccoach\dailyworkout;

use perccoach\dailyworkout\meta;

class shortcodes {

	public function register() {

		add_shortcode( meta::SHORTCODE, [ $this, 'main_workout_output' ] );

	}

	public function main_workout_output() {

		return '<div id="dailyworkout">Hello World</div>';

	}
}
