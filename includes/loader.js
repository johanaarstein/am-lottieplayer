import modules from './modules';

addEventListener( 'et_builder_api_ready', ( e, API ) => {
	API.registerModules( modules );
} );
