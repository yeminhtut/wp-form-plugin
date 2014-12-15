<?php 
    /*
    Plugin Name: Contest
    Plugin URI: http://www.magdev.tripzilla.com
    Description: Plugin for displaying persons those participating in contest
    Author: Ye Min Htut
    Version: 1.0
    Author URI: http://www.magdev.tripzilla.com
    */
add_action( 'admin_menu', 'contest_table' );

function contest_table() {
	add_options_page( 'Contest Table', 'Contest', 'manage_options', '1', 'my_plugin_options' );
	//add_options_page( 'Contest Table', 'Contest', 'manage_options', '2', 'my_plugin_options' );
}
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}	
	get_template_part( 'partials/template', 'contest' );
}
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
