const path = require("path"),
	removeEmptyScriptsPlugin = require("webpack-remove-empty-scripts"),
	webpackConfig = require("@wordpress/scripts/config/webpack.config");

// Extend the @wordpress webpack config and add the entry points.
module.exports = {
	...webpackConfig,
	...{
		mode: "production",
		devServer: {
			static: {
				directory: path.join(__dirname, "assets"),
			},
			client: {
				overlay: false,
			},
			// open: ["http://localhost:8212/www8212/mabastos"], // (Optional) Add your local domain here
			
			//open: ["https://mercadoabastos.local/"], // (Optional) Add your local domain here
			open: ["http://localhost:10004/"], // (Optional) Add your local domain here
			
			
			liveReload: true,
			hot: false,
			compress: true,
			devMiddleware: {	
				writeToDisk: true,
			},
		},
		context: path.resolve(__dirname, "assets"),
		entry: ["./main.js", "./main.scss"],
		// jQuery support
		/*externals: {
			jquery: "jQuery",
		},*/
		plugins: [
			...webpackConfig.plugins,
			/*new webpack.ProvidePlugin({
				$: "jquery",
				jQuery: "jquery",
				"window.jQuery": "jquery",
			}),*/
			new removeEmptyScriptsPlugin({
				stage: removeEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
			}),
		],
	},
};
