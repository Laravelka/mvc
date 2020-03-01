const path = require('path');
const webpack = require( 'webpack' );
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

const distPath = path.join(__dirname, '/public');

const config = {
	entry: ['./assets/js/app.js', './assets/css/app.css'],
	output: {
		path: distPath,
		filename: 'js/app.js'
	},
	devtool: 'cheap-eval-source-map',
	module: {
		rules: [
			{
				test: /\.jsx$|\.es6$|\.js$/,
				use: {
					loader: 'babel-loader'
				},
				exclude: /(node_modules|bower_components)/
			},
			{
				test: /\.css$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							name: 'css/app.css',
							importLoaders: 1,
							sourceMap: true,
						}
					},
					{
						loader: 'postcss-loader',
						options: {
							plugins: [ require( 'autoprefixer' ) ]
						}
					}
				]
			}
		]
	},
	plugins: [
        new MiniCssExtractPlugin({
			filename: 'css/app.css',
			chunkFilename: '[id].css'
		}),
		new OptimizeCssAssetsPlugin({
			assetNameRegExp: /\.css$/g,
			cssProcessor: require('cssnano'),
			cssProcessorPluginOptions: {
				preset: ['default', { discardComments: { removeAll: true } }],
			},
			canPrint: true
		}),
		new webpack.ProvidePlugin({
			'$': 'jquery',
			jquery: 'jquery',
			jQuery: 'jquery',
			'window.jquery': 'jquery',
			'window.jQuery': 'jquery'
		})
	]
};

module.exports = config;