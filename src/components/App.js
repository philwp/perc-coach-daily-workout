import React from 'react';
import TrackList from './TrackList';
import Player from './Player';
import Timer from './Timer';
import TrackPicker from './TrackPicker';
import TheTitle from './TheTitle';
import AudioPlayer from './AudioPlayer';


class App extends React.Component {

  constructor(){
    super();
    this.getWorkoutFromApiAsync = this.getWorkoutFromApiAsync.bind(this);
    this.state = {
      workout: {}

    };
    let postId = document.querySelector("#dailyworkout-wrapper").dataset.dwid;
    fetch('http://thepercussioncoach.com/wp-json/wp/v2/workouts/' + postId)
      .then((response) =>  response.json()).then((responseData) => {
        this.setState({workout: responseData});
      })
      .catch(err => console.log(err))
  }

  getWorkoutFromApiAsync() {
    let postId = document.querySelector("#dailyworkout-wrapper").dataset.dwid;
    return fetch('http://thepercussioncoach.com/wp-json/wp/v2/workouts/' + postId)
      .then((response) =>  response.json()).then((responseData) => {
        this.setState({workout: responseData});
      })
      .catch(err => console.log(err))

  }


	render() {

    let playlist = [];
    let exercises =  this.state.workout.exercises;
    //let title = this.state.workout.title.rendered;
    for ( var exercise in exercises) {
      let numberOfExercises = exercises[exercise].tracks.length;
      console.log("number of exercises: " + numberOfExercises + " for " + exercise);

      for ( var i = 0; i < numberOfExercises; i++ ){
        let exerciseObj = {};
        exerciseObj.displayText = exercises[exercise]['title'];
        let theTracks = exercises[exercise].tracks[i];
        exerciseObj.url = theTracks.pcdw_audio;
        exerciseObj.tempo = theTracks.pcdw_tempo;
        exerciseObj.sheetMusic = exercises[exercise]['sheet_music'];
        playlist.push(exerciseObj);
      }
    }
    console.log(playlist);

      return (
        <div>

          <div>

            <AudioPlayer playlist={playlist} />

          </div>

        </div>
    );


	}
}

export default App;
