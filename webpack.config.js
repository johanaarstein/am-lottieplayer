const defaults = require("@wordpress/scripts/config/webpack.config"),
	{ getWebpackEntryPoints } = require("@wordpress/scripts/utils/config"),
	{ join, resolve } = require("path"),
	{ writeFile } = require("fs"),
	{ sync } = require("glob"),
	rename = () => {
		const blockJSONFiles = sync(
			join(process.cwd(), "build", "**", "block.json"),
		);

		if (blockJSONFiles) {
			for (const filePath of blockJSONFiles) {
				const blockJSON = require(filePath);

				if (!blockJSON)
					continue

				if (blockJSON.editorScript)
					blockJSON.editorScript = blockJSON.editorScript.replace(
						".tsx",
						".js",
					);
				if (blockJSON.script)
					blockJSON.script = blockJSON.script.replace(".tsx", ".js");
				if (blockJSON.viewScript)
					blockJSON.viewScript = blockJSON.viewScript.replace(".tsx", ".js");
				if (blockJSON.editorStyle)
					blockJSON.editorStyle = blockJSON.editorStyle.replace(
						".scss",
						".css",
					);
				if (blockJSON.style)
					blockJSON.style = blockJSON.style.replace(".scss", ".css");

				writeFile(
					filePath,
					JSON.stringify(blockJSON, null, 2),
					(error) => {
						if (error) return console.log(error);
					},
				);
			};
		}
	};

module.exports = {
	...defaults,
	entry: {
		...getWebpackEntryPoints(),
		widget: "./src/Widget.tsx"
	},
	plugins: [
		...defaults.plugins,
		{
			apply: ({ hooks }) => {
				hooks.afterEmit.tap("rename", rename);
			},
		},
	],
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
