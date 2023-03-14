const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
	...defaultConfig,

	// entry: `./src/index.ts`,

	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.tsx?$/,
				use: [
					{
						loader: 'ts-loader',
						options: {
							configFile: './tsconfig.json',
							transpileOnly: true,
						},
					},
				],
			},
		],
	},
	resolve: {
		extensions: [
			'.ts',
			'.tsx',
			...(defaultConfig.resolve
				? defaultConfig.resolve.extensions || ['.js', '.jsx']
				: []),
		],
	},
}
