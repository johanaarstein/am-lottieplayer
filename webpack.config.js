const defaults = require("@wordpress/scripts/config/webpack.config"),
	// { getWebpackEntryPoints } = require("@wordpress/scripts/utils/config"),
	{ resolve } = require("path");

module.exports = {
	...defaults,
	entry: {
		"lottiecover/index": "/src/lottiecover/index.ts",
		"lottieplayer/index": "/src/lottieplayer/index.ts",
		// ...getWebpackEntryPoints(),
		admin: "./src/admin.tsx",
	},
	resolve: {
		...defaults.resolve,
		alias: {
			...defaults.resolve.alias,
			"@assets": resolve(__dirname, "src/assets"),
			"@components": resolve(__dirname, "src/components"),
			"@context": resolve(__dirname, "src/context"),
			"@types": resolve(__dirname, "src/types"),
			"@utils": resolve(__dirname, "src/utils"),
		},
	},
};
