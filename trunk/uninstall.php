<?php

if (
	! defined( 'WP_UNINSTALL_PLUGIN' )
	||
	! WP_UNINSTALL_PLUGIN
	||
	dirname( WP_UNINSTALL_PLUGIN ) != dirname( plugin_basename( __FILE__ ) )
) {
	status_header( 404 );
	exit;
}

delete_option( 'dm_disclaimer_manager' );