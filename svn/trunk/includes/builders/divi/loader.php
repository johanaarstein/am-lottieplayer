<?php
( \defined( 'ABSPATH' ) && \class_exists( 'ET_Builder_Element' ) ) || exit;

$module_files = \glob( __DIR__ . '/modules/**/*.php' );

foreach ( (array) $module_files as $module_file ) {
	if ( $module_file ) {
		require_once $module_file;
	}
}
