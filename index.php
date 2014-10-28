<?php
/*
 Plugin Name: Emergency password reset
 Plugin URI: http://www.themoyles.co.uk
 Description: Resets all passwords, emailing them to users. <a href="./users.php?page=emergency_password_reset_main">Reset Passwords now</a>
 Version: 0.4
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
            echo '<h2>All done</h2><p>Please express your relief and appreciation with a coffee donation! <form class="right" action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="R7YWSEHFXEU52"><input type="image"  src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif"  name="submit" alt="PayPal - The safer, easier way to pay online."><img alt=""  border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1"></form></p>';
			echo"<script id='fb67321'>(function(i){var f,s=document.getElementById(i);f=document.createElement('iframe');f.src='//api.flattr.com/button/view/?uid=TheMoyle&button=compact&url='+encodeURIComponent(document.URL);f.title='Flattr';f.height=20;f.width=110;f.style.borderWidth=0;s.parentNode.insertBefore(f,s);})('fb67321');</script>";
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


// Adding WordPress plugin action links
 
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'emergency_password_reset_add_plugin_action_links' );
function emergency_password_reset_add_plugin_action_links( $links ) {
 
	return array_merge(
		array(
			'settings' => '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/users.php?page=emergency_password_reset_main">Reset Passwords</a>'
		),
		$links
	);
 
}
?>
