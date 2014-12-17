<?php 
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $error = false;
    // set the "required fields" to check
    $required_fields = array( "your_name", "email", "message", "subject" );
 
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
 
    // and if the e-mail is not valid, switch $error to TRUE and set the result text to the shortcode attribute named 'error_noemail'
    if ( ! is_email( $form_data['email'] ) ) {
        $error = true;
        $result = $error_noemail;
    }
 
    if ( $error == false ) {
        $email_subject = "[" . get_bloginfo( 'name' ) . "] " . $form_data['subject'];
        $email_message = $form_data['message'] . "\n\nIP: " . wptuts_get_the_ip();
        $headers  = "From: " . $form_data['name'] . " <" . $form_data['email'] . ">\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\n";
        $headers .= "Content-Transfer-Encoding: 8bit\n";
        wp_mail( $email, $email_subject, $email_message, $headers );
        $result = $success;
        $sent = true;
    }
    // but if $error is still FALSE, put together the POSTed variables and send the e-mail!
    if ( $error == false ) {
        // get the website's name and puts it in front of the subject
        $email_subject = "[" . get_bloginfo( 'name' ) . "] " . $form_data['subject'];
        // get the message from the form and add the IP address of the user below it
        $email_message = $form_data['message'] . "\n\nIP: " . wptuts_get_the_ip();
        // set the e-mail headers with the user's name, e-mail address and character encoding
        $headers  = "From: " . $form_data['your_name'] . " <" . $form_data['email'] . ">\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\n";
        $headers .= "Content-Transfer-Encoding: 8bit\n";
        // send the e-mail with the shortcode attribute named 'email' and the POSTed data
        wp_mail( $email, $email_subject, $email_message, $headers );
        // and set the result text to the shortcode attribute named 'success'
        $result = $success;
        // ...and switch the $sent variable to TRUE
        $sent = true;
    }
}

?>