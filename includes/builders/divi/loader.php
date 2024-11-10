<?php
\defined( 'ABSPATH' ) || exit;

$module_files = \glob( __DIR__ . '/modules/*.php' );

if ( ! $module_files ) {
	return;
}

foreach ( (array) $module_files as $module_file ) {
	if ( ! $module_file ) {
		continue;
	}
	require_once $module_file;
}
