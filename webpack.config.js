const defaults = require("@wordpress/scripts/config/webpack.config"),
	{ resolve } = require("path");

module.exports = {
	...defaults,
	entry: {
		"lottiecover/index": "/src/lottiecover/index.ts",
		"lottieplayer/index": "/src/lottieplayer/index.ts",
		admin: "./src/admin.tsx",
	},
	resolve: {
		...defaults.resolve,
		alias: {
			...defaults.resolve.alias,
			"@": resolve(__dirname, "src"),
		},
	},
};
