<?php
/*
 Plugin Name: Emergency password reset
 Plugin URI: 
 Description: Resets all passwords, emailing them to users
 Version: 0.1
 Author: andymoyle
 Author URI:http://www.themoyles.co.uk
 */


//Menu
add_action('admin_menu','add_usermenu_item');
function add_usermenu_item()
{
    add_submenu_page('users.php', 'Emergency Password Reset', 'Emergency Password Reset', 'administrator', 'emergency_password_reset_main', 'emergency_password_reset_main' );
}

function emergency_password_reset_main()
{
    if(current_user_can('manage_options'))
    {
        global $wpdb;
        $wpdb->show_errors();
        echo'<h2>Emergency Password Reset Main</h2>';
        if(!empty($_POST['emergency_accept']) && check_admin_referer('emergency_reset','emergency_reset'))
        {
            echo'<p>Okay...</p>';
            $results=$wpdb->get_results('SELECT ID FROM '.$wpdb->prefix.'users');
            if($results){foreach($results AS $row){emergency_password_reset($row->ID);}}
        }
        else
        {
            echo'<p><form action="" method="post">';
            echo wp_nonce_field('emergency_reset','emergency_reset');
            echo'<input type="hidden" name="emergency_accept" value="yes"/><input type="submit" value="Reset all passwords"/></form></p>';
        }
    }
    else{echo"<p>You don't have permission to use this password reset</p>";}
}

function emergency_password_reset($user_id)
{
    if(current_user_can('manage_options'))
    {
        $password=wp_generate_password();
        wp_set_password( $password, $user_id );
        $user = get_userdata( $user_id );
        $message='<p>We have had to reset your password on '.site_url().'<br/>Your username is still '.$user->user_login.', but your new password is '.$password.'<br/> Thanks.</p>';
        echo'<p>Password changed for '.$user->user_login.'</p>';
        add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
        wp_mail($user->user_email,'Password reset for '.site_url(),$message);
    }
}
?>