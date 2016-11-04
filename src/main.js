alert('working');

import React from "react";
import ReactDOM from 'react-dom';

class HelloWorld extends React.Component {
	render() {
		return <h1>Hello React</h1>
	}
}

ReactDOM.render( <HelloWorld />, document.querySelector('#dailyworkout'));
