<?php
/*
WP-Notes Installer
*/

function wpnotes_install () {
  global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$tablename = $wpdb->prefix . "notes"; /* OK */
	$sql = "CREATE TABLE IF NOT EXISTS `$tablename` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`content` text NOT NULL,
		PRIMARY KEY (`id`)
	);";
	dbDelta($sql);
	$wpdb->insert("{$wpdb->prefix}notes",array("id"=>0,"content"=>"این یک یادداشت است."),array("%d","%s"));
}
