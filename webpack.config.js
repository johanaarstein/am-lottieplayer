const defaults = require("@wordpress/scripts/config/webpack.config"),
	{ resolve } = require("path")

/**
 * @type {import('webpack').Configuration}
 * */
module.exports = {
	...defaults,
	entry: {
		"lottiecover/index": resolve(__dirname, "src", "lottiecover", "index.ts"),
		"lottieplayer/index": resolve(__dirname, "src", "lottieplayer", "index.ts"),
		admin: resolve(__dirname, "src", "admin.tsx"),
		media: resolve(__dirname, "src", "media.ts"),
	},
	resolve: {
		...defaults.resolve,
		alias: {
			...defaults.resolve.alias,
			"@": resolve(__dirname, "src"),
		},
	},
};
