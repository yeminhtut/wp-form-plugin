<?php 
    /*
    Plugin Name: Contest
    Plugin URI: http://www.magdev.tripzilla.com
    Description: Plugin for displaying persons those participating in contest
    Author: Ye Min Htut
    Version: 1.0
    Author URI: http://www.magdev.tripzilla.com
    */
if ( ! defined( 'TZ_PLUGIN_DIR' ) )
	define( 'TZ_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

add_action( 'admin_menu', 'contest_table' );

function contest_table() {
	add_options_page( 'Contest Table', 'Contest', 'manage_options', '1', 'my_plugin_options' );
	//add_options_page( 'Contest Table', 'Contest', 'manage_options', '2', 'my_plugin_options' );
}
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}	
	$template_path =  TZ_PLUGIN_DIR . 'template/admin-template.php';
	include($template_path);
}

/*Database Creation */
global $jal_db_version;
$jal_db_version = '1.0';
function jal_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'liveshoutbox';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (id mediumint(9) NOT NULL AUTO_INCREMENT,time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		text text NOT NULL,
		url varchar(55) DEFAULT '' NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}

function jal_install_data() {
	global $wpdb;
	
	$welcome_name = 'Mr. WordPres';
	$welcome_text = 'Congratulations, you just completed the installation!';
	
	$table_name = $wpdb->prefix . 'liveshoutbox';
	
	$wpdb->insert( 
		$table_name, 
		array( 
			'time' => current_time( 'mysql' ), 
			'name' => $welcome_name, 
			'text' => $welcome_text, 
		) 
	);
}
//register_activation_hook( __FILE__, 'jal_install' );
/*End of database Creation */
?>
<?php // shortcode for homepage link
function retrieve_contest_form() {
$contest_form = '<div class="wrap">     
    <form name="oscimp_form" method="post" action="">
        <input type="hidden" name="" value="">        
        <p><input type="text" name="" value="" size="20"></p>
        <p><input type="text" name="" value="" size="20"></p>
        <p><input type="text" name="" value="" size="20"></p>
        <p><input type="text" name="" value="" size="20"></p>        
        <p><input type="text" name="" value="" size="20"></p>
        <p><input type="text" name="" value="" size="20"></p>     
        <p class="submit">
        <input type="submit" name="Submit" value="Submit" />
        </p>
    </form>
</div>';
return $contest_form;
}
add_shortcode('contest_form_short_code', 'retrieve_contest_form');
?>
<?php
 
