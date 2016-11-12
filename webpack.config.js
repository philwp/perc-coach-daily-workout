var ExtractTextPlugin = require('extract-text-webpack-plugin');


var webpackConfig = {
	entry: './src/main.js',
	output: {
		filename: './index.js'
	},
	module: {
		loaders: [
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				loader: 'babel',
				query: {
					presets: ['es2015', 'react']
				}
			},

		    {
		        test: /\.scss$/,
		        loader: 'style-loader!css-loader!sass-loader'
		    }



    	]
  	}

};

module.exports = webpackConfig;
