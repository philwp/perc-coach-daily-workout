import React from 'react';
import TheTitle from './TheTitle';


class Player extends React.Component {

	render() {
		return (
			<div className="player">
				<TheTitle theTitle={this.props.exerciseTitle} /><p>{this.props.tempo}</p>
				<img src={this.props.sheetMusicSource} />

				<p>Play Button</p>

			</div>
		);
	}
}

export default Player;
