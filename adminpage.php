<h2>My Login/Logout Admin Page</h2>

<div align="left" id="my_div" class="my_div">
<h3>Select redirection Pages after Login/logout</h3>
<!--Submitting the form-->
<?php $option = get_option( 'mylogin_option' );
	if ( $_REQUEST['page'] == 'mylogin_send' && isset( $_POST['submit'] ) )
	{

		$mylogin1=$_POST['page-dropdown1'];
		$mylogout1=$_POST['page-dropdown2'];

		global $wpdb;

			$wpdb->update( 
				'wp_mylogin', 
					array( 
					'login_page' => $mylogin1,	
					'logout_page' => $mylogout1,
					'modified_date' => current_time( 'mysql' )), 
					array( 'id' => 1 ), 
					array( '%s','%s','%s'),	array( '%d' ));

	}

 ?>
<!--Submitting the form End-->

<form method="post" action="" id="send-form" enctype="multipart/form-data">
	    
	<input type="hidden" name="page" value="mylogin_send" />
		<table  width="400px" cellpadding="0" cellspacing="0" border="0" class="display" id="example"><tr>
		<td>Login</td><td><select name="page-dropdown1" >  
    		<option value="index.php"><?php echo attribute_escape(__('Select page')); ?></option> 
    				<?php 
       				 $pages = get_pages(); 
      					  foreach ($pages as $pagg) {
           					 $option = '<option value="'.$pagg->ID.'">';
          					 $option .= $pagg->post_title;
           					 $option .= '</option>';
            					 echo $option;      }
   					 ?>
				</select></td></tr>
<tr><td>&nbsp</td></tr>
<tr><td>Logout</td><td>
		<select name="page-dropdown2" > 
    			<option value="index.php"><?php echo attribute_escape(__('Select page')); ?></option> 
   			 <?php 
       				 $pages = get_pages(); 
       				 foreach ($pages as $pagg) {
         			 $option = '<option value="'.$pagg->ID.'">';
           			 $option .= $pagg->post_title;
           			 $option .= '</option>';
           			 echo $option; }
   				 ?>
		</select></td></tr>
<tr><td>&nbsp</td><td>&nbsp</td></tr>
<tr><td colspan="2" align="right"> <p class="submit"><input type="submit" value="Send" class="button-primary" id="submit" name="submit"></p></td></tr>
   </table>
</form>
<div>

 <?php

global $wpdb; $user_count = $wpdb->get_row( "SELECT * FROM wp_mylogin" );
 		$myloginid= $user_count->login_page;
$mylogoutid= $user_count->logout_page;
  ?>
<p>Current Login Redirect page is &nbsp&nbsp=&nbsp<b><?php echo get_the_title($myloginid); ?></b></p>
<p>Current Logout Redirect page is &nbsp&nbsp=&nbsp<b><?php echo get_the_title($mylogoutid); ?></b></p>
</div>
</div>









