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

//register_activation_hook(__FILE__,'wpnotes_install');
include 'wpnotes_install.php';

// Run the add_notes_widget() function and it's for WordPress Hook
add_action('wp_dashboard_setup', 'add_notes_widget' );
add_action( 'admin_init', 'register_styles' );
add_action( 'admin_init', 'update_note' );


register_activation_hook(__FILE__,'wpnotes_install');
global $wpdb;
function update_note($note_content) {
  global $wpdb;
//	$wpdb->update("{$wpdb->prefix}notes",array('content'=>$_POST['note']) ,array('id'=>1));

if(isset($_POST['note']) && $_POST['note'] != '') {
	//update_note($_POST['note']);
	//require_once( ABSPATH . 'wp-load.php' );
	global $wpdb;
	$wpdb->update("{$wpdb->prefix}notes",array('content'=>$_POST['note']) ,array('id'=>1));
	//var_dump($wpdb);
	//$wpdb->query("UPDATE {$wpdb->prefix}notes SET content={$_POST['note']} WHERE id='1' ");
	//require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	//add_action( 'publish_post', 'update_note' );
	//header('Location: ../../');
}
}
// Define Static Variables
define('plugin_url', get_option('siteurl').'/wp-content/plugins/wp-notes');







// Create the Notes Dashboard Widget & run a Notes() function
function add_notes_widget() {
	wp_add_dashboard_widget('notes', 'یادداشت‌ها', 'Notes');	
}
// Create the function to output the contents of our Dashboard Widget
function Notes() {
	//$mylink = $wpdb->get_row("SELECT * FROM $wpdb->"prefix . "notes WHERE id = 1");
	// Display whatever it is you want to show
	global $wpdb;
	$note = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}notes WHERE `id` = 1", ARRAY_A);
	echo '
<form action="" method="POST">
<div class="note">
<textarea id="note" name="note">'.$note['content'].'</textarea>
<div class="actions">
	<div class="left"><input type="submit" name="publish" id="publish" accesskey="p" class="button-primary" value="ذخیره"></div>
	<div class="right"><input type="submit" name="save" id="save-post" class="button" value="از نو" onclick="clear_textarea()"></div>
</div>
</div>
<div class="clearfix"></div>
</form>
';
}

function register_styles()
{  
	// Register the style like this for a plugin:  
	wp_register_style( 'custom-style', plugins_url( '/notes-style.css', __FILE__ ), array(), '20120208', 'all' );    

	// For either a plugin or a theme, you can then enqueue the style:  
	wp_enqueue_style( 'custom-style' );  
}
