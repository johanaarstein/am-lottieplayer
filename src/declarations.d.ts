declare module '@wordpress/scripts/config/webpack.config' {
	import type { Configuration } from 'webpack';
	const config: Configuration;
	export default config;
}

declare module '@wordpress/scripts/utils/config' {
	import type { EntryObject } from 'webpack';
	const getWebpackEntryPoints: () => EntryObject;
}
