<?php
/*
Plugin Name: WP-Notes
Plugin URI: http://mmnaderi.github.io/wp-notes
Description: A place for your Notes | جایی برای یادداشت هایتان
Version: 1.0.1
Author: Mohammad Mahdi Naderi
Author URI: http://mmnaderi.ir
License: GPL3
*/

// Include wpnotes_install.php for install plugin
include 'wpnotes_install.php';

// Load Language File
add_action( 'admin_init', 'load_lang' );
function load_lang() {
	$path = dirname(plugin_basename( __FILE__ )) . '/lang/';
	$loaded = load_plugin_textdomain( 'wpnotes', false, $path);
}

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
	wp_add_dashboard_widget('notes', __('Notes', 'wpnotes'), 'Notes');	
}

// Function that output the contents of our Dashboard Widget
function Notes() {
	global $wpdb;
	$note = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}notes WHERE `id` = 1", ARRAY_A);
	echo '<form action="" method="POST">
	<div class="note">
	<textarea id="note" name="note">'.$note['content'].'</textarea>
	</div>
	<div class="'. __("direction-ltr","wpnotes") .'">
		<div class="save"><input type="submit" name="publish" id="publish" accesskey="p" class="button-primary" value="'. __("Save", "wpnotes") .'"></div>
		<div class="clear"><input type="button" name="clear" id="clear" class="button" value="'. __("Clear","wpnotes") .'" onclick="document.getElementById(\'note\').value = \'\';"></div>
	</div>
	<div class="clearfix"></div>
	</form>
	<script type="text/javascript">
		// <![CDATA[
		jQuery.noConflict();
		jQuery(document).ready(function(){			
			jQuery(\'textarea#note\').elastic();
			jQuery(\'textarea#note\').trigger(\'update\');
		});	
		// ]]>
	</script>';
}

function register_styles() {  
	// Register the style of notes
	wp_register_style('custom-style', plugins_url( '/notes-style.css', __FILE__ ), array(), '20120208', 'all');    
	wp_enqueue_style('custom-style');
	wp_register_script('custom-js', plugins_url( '/jquery.elastic.source.js', __FILE__ ), array('jquery'), 1.3, false);
	wp_enqueue_script('custom-js');
}