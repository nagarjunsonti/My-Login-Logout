<?php
/*
Plugin Name: My login/Logout 
Plugin URI:http://172.10.1.3:8056/Nagarjuna/firstplugin
Description:With this plugin you can now add a real log in/logout item menu with auto switch when user is logged in or not.it works both Custom menubar as well as Defult menubar.We have a flexibility to set custom redirect pages for login as well as logout.it works both custom menu bar as well as default menu bar 
Author: Nagarjun Sonti
Author URI: http://172.10.1.3:8056/Nagarjuna/firstplugin
Version: 2.2
License: GPL2 or later

*/
/*

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

/* wp_mylogin table creation  and insert the initial data**/
register_activation_hook(__FILE__, 'mylogin_logout');
function mylogin_logout(){
	global $wpdb;
	$table_name='mylogin';

if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

	$sql = "CREATE TABLE IF NOT EXISTS wp_mylogin (
	id int(11) NOT NULL AUTO_INCREMENT,
	login_page varchar(128) NOT NULL,
	logout_page varchar(128) NOT NULL,
	created_date date NOT NULL,
	modified_date date  NULL,
	PRIMARY KEY (id)
	) COLLATE utf8_general_ci;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

$wpdb->insert( 
	'wp_mylogin', 
	array( 
		'login_page' =>'index.php', 
		'logout_page' =>'index.php', 
		'created_date' =>current_time( 'mysql' ), 
		'modified_date' => '' 
		) );

}

}
/* wp_mylogin table creation  and insert the initial data  end *************/  

/* Including css**/
function add_my_css(){
       
        wp_enqueue_style( 'mystyle', plugins_url('/mystyle.css', __FILE__), false, '1.0.0', 'all');
    }
    add_action('admin_enqueue_scripts', "add_my_css");

/* including css end *******/


/* retreiving data from the table and set as global variable**/
		
			
	function wtnerd_global_vars() {

	   global $wpdb;
	   global $myloginid;
	   global $mylogoutid;
		$user_count = $wpdb->get_row( "SELECT * FROM wp_mylogin" );
 		$myloginid= get_permalink($user_count->login_page);
		$mylogoutid= get_permalink($user_count->logout_page);
	}
	add_action( 'parse_query', 'wtnerd_global_vars' );

/* retreiving data from the table and set as global variable End ********/

/* Defult Menu Bar**/
function add_login_logout($items, $args)
{
	global $myloginid;
	global $mylogoutid;


	if(is_user_logged_in())
	{


		$newitems = '<li><a title="Logout" href="'. wp_logout_url($mylogoutid) .'">logout</a></li>';
		$items .= $newitems.$variable;
	}
	else
	{
		$newitems = '<li><a title="Login" href="'. wp_login_url($myloginid) .'">login</a></li>';
		$items .= $newitems;
	}
	return $items;
}
add_filter('wp_list_pages', 'add_login_logout', 10, 20);

/* Defult Menu Bar  End  *************/

/* Custom Menu Bar  **/
function add_login_logout_link($items, $args)
{


	global $myloginid;
	global $mylogoutid;

	if(is_user_logged_in())
		{

			$newitems = '<li><a title="Logout" href="'. wp_logout_url($mylogoutid) .'">logout</a></li>';
			$items .= $newitems;
		}
	else
		{
			$newitems = '<li><a title="Login" href="'. wp_login_url($myloginid) .'">login</a></li>';
			$items .= $newitems;
}

return $items;

}
add_filter('wp_nav_menu_items', 'add_login_logout_link', 1, 2);

/* Custom Menu Bar End **************/

/* Creating Lable on admin side bar  **/
add_action('admin_menu', 'plugin_admin_add_page');
function plugin_admin_add_page()
 {
	add_options_page( 'custom menu title', 'My Login/logout', 'manage_options', 'login_logout/adminpage.php');
}
 /* Creating Lable on admin side bar  End ******/
function my_enqueue($hook) {

	if( 'login_logout/adminpage.php' != $hook )
	return;
}
 
add_action( 'admin_enqueue_scripts', 'my_enqueue' );


