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
function table_install() {
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
//register_activation_hook( __FILE__, 'table_install' );
/*End of database Creation */
?>
<?php // shortcode for homepage link
function retrieve_contest_form() {
$process_path = get_permalink();
extract( shortcode_atts( array(
    "subject" => "",
    "label_name" => "Name",
    "label_email" => "E-mail Address",
    "label_contact" => "Contact No. (Optional)",    
    "label_submit" => "Submit",
    // the error message when at least one of the required fields are empty:
    "error_empty" => "Please fill in all the required fields.",
    // the error message when the e-mail address is not valid:
    "error_noemail" => "Please enter a valid e-mail address.",
    "user_exist" => "user_exist",
    // and the success message when the e-mail is sent:
    "success" => "Thank you for your participation in TripZilla Stays Giveaway."
), $atts ) );
/*Second Part */
	 if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	    $error = false;
	    // set the "required fields" to check
	    $required_fields = array( "your_name", "email", "contact_number" );	 
	    // this part fetches everything that has been POSTed, sanitizes them and lets us use them as $form_data['subject']
	    foreach ( $_POST as $field => $value ) {
	        if ( get_magic_quotes_gpc() ) {
	            $value = stripslashes( $value );
	        }
	        $form_data[$field] = strip_tags( $value );
	    }	 
	    // if the required fields are empty, switch $error to TRUE and set the result text to the shortcode attribute named 'error_empty'
	    foreach ( $required_fields as $required_field ) {
	        $value = trim( $form_data[$required_field] );
	        if ( empty( $value ) ) {
	            $error = true;
	            $result = $error_empty;
	        }
	    }
	    if (empty($result)) {
	    	// and if the e-mail is not valid, switch $error to TRUE and set the result text to the shortcode attribute named 'error_noemail'
		    if ( ! is_email( $form_data['email'] ) ) {
		        $error = true;
		        $result = $error_noemail;
		    }
		    else{
		    	/*check user exist */
			    global $wpdb;
			    $user_email = $form_data['email'];
			    $user_name = $form_data['your_name'];
			    $user_contact = $form_data['contact_number'];
			    $sql = "SELECT Email FROM  `t_contest` WHERE  `Email` LIKE  '$user_email'";
				$check_user = $wpdb->get_results( $sql, OBJECT );
				if (!empty($check_user)) {
					$error = true;
					$result = $user_exist;
				}
				else{
					$error = true;
					$sql = "INSERT INTO `blog`.`t_contest` (`Email`, `Name`, `Contact`,`Created_Date`, `Contest`) VALUES (NULL, '$user_email', '$user_name', '$user_contact', NOW(), '2');";
					//$wpdb->insert( $sql, OBJECT );
					$wpdb->insert( 't_contest', array( 'Email' => $user_email,'Name' => $user_name,'Contact' => $user_contact ));
					$to = 'yehtut.it@gmail.com';
					$subject = "Success Message";
					$message = 'You have successfully submitted';
					$headers  = "From: Ye Min Htut <yehtut.it@gmail.com>\n";
			        $headers .= "Content-Type: text/plain; charset=UTF-8\n";
			        $headers .= "Content-Transfer-Encoding: 8bit\n";
					//wp_mail( $to, $subject, $message, $headers, $attachments );
					$error = false;
					$sent = true;
				}
		    }
	    }
	    
	    
	 	if ( $error == false ){
	 		//$result = var_dump($check_user);
	 		$result = $success;
	 	}
	}
/*Third Part */

if ( $result != "" ) {
    $info = '<div class="info">' . $result . '</div>';
}
$email_form = '<form class="contest-form" method="post" action="' . get_permalink() . '">
	<div id="cf_input_wrapper">
    <div>
        <input type="text" name="your_name" id="cf_name" size="50" maxlength="50" placeholder = "' . $label_name .'" value="' . $form_data['your_name'] . '" />
    </div>
    <div>
        <input type="text" name="email" id="cf_email" size="50" maxlength="50" placeholder = "' . $label_email .'" value="' . $form_data['email'] . '" />
    </div>
    <div>
        <input type="text" name="contact_number" id="cf_contact" size="50" maxlength="50" placeholder = "' . $label_contact .'" value="'.$form_data['contact_number'] . '" />
    </div>
    </div>
    <div>
        <input type="submit" value="' . $label_submit . '" name="send" id="cf_send" />
    </div>
</form>';
return $info . $email_form;
}
add_shortcode('contest_form_short_code', 'retrieve_contest_form');
?>
