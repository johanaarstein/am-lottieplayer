<?php
\defined( 'ABSPATH' ) || exit;

$aamd_module_files = \glob( __DIR__ . '/modules/*.php' );

if ( ! $aamd_module_files ) {
	return;
}

foreach ( (array) $aamd_module_files as $aamd_module_file ) {
	if ( ! $aamd_module_file ) {
		continue;
	}
	require_once $aamd_module_file;
}
