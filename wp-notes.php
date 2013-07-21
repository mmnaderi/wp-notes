<?php
/*
Plugin Name: WP-Notes
Plugin URI: https://github.com/mmnaderi/wp-notes
Description: جایی برای نوشتن یادداشت هایتان
Version: 1.0
Author: محمّد مهدی نادری
Author URI: http://mmnaderi.ir
License: GPL3
*/

// Include wpnotes_install.php for install plugin
include 'wpnotes_install.php';

// Run the add_notes_widget() function and it's for WordPress Hook
add_action('wp_dashboard_setup', 'add_notes_widget' );
add_action( 'admin_init', 'register_styles' );
add_action( 'admin_init', 'update_note' );

register_activation_hook(__FILE__,'wpnotes_install');
global $wpdb;

// Update Notes
function update_note($note_content) {
	global $wpdb;
	if(isset($_POST['note']) && $_POST['note'] != '') {
		global $wpdb;
		$wpdb->update("{$wpdb->prefix}notes",array('content'=>$_POST['note']) ,array('id'=>1));
	}
}

// Define Static Variables
define('plugin_url', get_option('siteurl').'/wp-content/plugins/wp-notes');

// Create the Notes Dashboard Widget & run a Notes() function
function add_notes_widget() {
	wp_add_dashboard_widget('notes', 'یادداشت‌ها', 'Notes');	
}

// Function that output the contents of our Dashboard Widget
function Notes() {
	global $wpdb;
	$note = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}notes WHERE `id` = 1", ARRAY_A);
	echo '<form action="" method="POST">
	<div class="note">
	<textarea id="note" name="note">'.$note['content'].'</textarea>
	<div class="actions">
		<div class="left"><input type="submit" name="publish" id="publish" accesskey="p" class="button-primary" value="ذخیره"></div>
		<div class="right"><input type="button" name="clear" id="clear" class="button" value="از نو" onclick="document.getElementById(\'note\').value = \'\';"></div>
	</div>
	</div>
	<div class="clearfix"></div>
	</form>';
}

function register_styles() {  
	// Register the style of notes
	wp_register_style( 'custom-style', plugins_url( '/notes-style.css', __FILE__ ), array(), '20120208', 'all' );    
	wp_enqueue_style( 'custom-style' );  
}
