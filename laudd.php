<?php
/**
 * Plugin Name: laudd
 * Plugin URI: https://laudd.com/plugin
 * Description: Free plugin offers users points content shared through this toolbar generates traffic back to your blog or news website. Enables you to mark premium content that can be viewed using the earned points.
 * Version: Laudd 4.3.5
 * Author: Laudd, Inc
 * Author URI: https://laudd.com
 * Tags: Laudd, laudd.com
 * License: GPL
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
 
 class Laudd
 {
   function __construct() 
   {		  
		//Activate Plugin
		register_activation_hook(__FILE__, array($this, 'laudd_activate'));
		
		//Calling Function Insert Menu Under Tools	
			add_action('admin_menu', array($this,'create_registration_form'));
								
		//Calling Function add Script In Head.
			add_action('wp_head', array( $this, 'register_plugin_scripts' ));
		
		//Calling Function add Style Sheet In Head.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
			
		// Call Redirect Function	
			add_action('admin_init', array($this, 'srpt_plugin_redirect'));
			
		// Add WP Ajax action for Site ID Check
			add_action('wp_ajax_check_laudd_site_id_status', array($this, 'check_laudd_site_id_status'));
			
		// Deactivate Laudd For Blank Site Id
			add_action('admin_head', array($this, 'deactivate_laudd_for_blank_site_id'));
		// Adding a setting link Under Plugin Name
			$plugin = plugin_basename(__FILE__); 
	
		if(strlen(get_option('laudd_siteid'))>0)
		{		
		   //Activating  Sessions
			add_action('init', array($this, 'metrics_session'));		
		   
			//Calling Function to Run Code in Single.PHP file
				add_filter('the_content', array( $this,'laudd_add_to_content')) ;
			
				
			/*
		   //Calling Function Add Custom Buttons to Editor
				add_action( 'admin_print_footer_scripts', array($this,'appthemes_add_quicktags') );

			//Calling Function add tool bar option for single post 
				add_action( 'add_meta_boxes', array($this, 'my_custom_field_checkboxes' ));
				add_action( 'save_post', array($this,'my_custom_field_data' ));
			
			//Calling Function to create Short Code for Laudd Toolbar	
				add_shortcode( 'LauddToolbar', array($this, 'laudd_toolbar') );
				add_shortcode('LauddObscure', array($this, 'laudd_obscure'));
				add_shortcode('LauddHide', array($this, 'laudd_hide'));
				
			//Add Button on side of Media Button
				add_action('media_buttons', array($this, 'add_mark_premium_Content_btn'), 20);
				add_action('wp_enqueue_media', array($this, 'include_laudd_button_js_file'), 21);
			*/

			//Code For Deactivation 
				register_deactivation_hook( __FILE__, array($this, 'deactivate_plugin' ));
				
		}
   }
   
	function processOption($varName)
    {
   			$x = get_option($varName);
   			if ($x !== FALSE) {
   				update_option($varName . '_old', $x);
   			}
   			delete_option($varName);
    }
   
   //--------------------------------------------------------------------------------------------------------------------------------------// 
	  // Deactivation Code Of plugin
	   function deactivate_plugin()
	   { 
			$this->processOption('laudd_siteid');
			$this->processOption('laudd_activated');
	   }
	
   
	//--------------------------------------------------------------------------------------------------------------------------------------// 
	  // Code For Adding Css And Js For Mark Premium Button
	   function include_laudd_button_js_file()
	   {
			wp_enqueue_script('laudd_button', plugins_url( '/js/lauddButton.js', __FILE__ ), array('jquery'), '1.0', true);
			wp_enqueue_style( 'laudd-button-css', plugins_url( '/css/lauddButton.css', __FILE__ ) );
	   }
	
   //--------------------------------------------------------------------------------------------------------------------------------------// 
	  // Code For Adding Mark Premium Content Button To Visual Editor
	   function add_mark_premium_Content_btn() 
	   {	
			$screen = get_current_screen();
			if($screen -> post_type == 'post')
			{
				$img = plugins_url( '/images/mpc.png', __FILE__ );
				$html = '<a href="#" title="Appears blurred to unprivileged users" id="Laudd_Obscure" class="masterTooltip button">Mark Premium Content</a>
				<div id="pop-laudd-main">
					<div id="dialog-pc-caption" >
							<img src="'.plugins_url( '/images/logo.png', __FILE__ ).'" />
							<h3> Add Optional Caption</h3>
							<p class="validateTips">The caption will only be seen by unprivileged users.</p>
							<textarea placeholder="Type Caption Here ....." id="caption-text"></textarea>
							<a href="#" id="new_cancel">Cancel</a>
							<button id="ok" class="ok-disable" disabled>Add Caption</button><a href="#" id="cancel">No Caption</a><a href="#" id="dialog-pc-example">See Example</a>
					</div>
					<div id="dialog-pc-eg"><img src="'.plugins_url( '/images/mpc_eg.png', __FILE__ ).'" />
							<div class="btn-container"><a href="#" id="eg-ok">OK</a></div>
					</div>
				<div class="black_overlay"></div>
				</div>	';		
				echo $html;		
			}
	   }
   
   //--------------------------------------------------------------------------------------------------------------------------------------// 
	  // Code for initiating Session   
		function metrics_session()
		{
			if(!session_id())
			{
				session_start();
			}
		}
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	  // Creating registration page for laudd   
	   function laudd_activate()
	   {
	   		delete_option('laudd_registered');
			update_option('srpt_activation_redirect', true);			
			update_option('laudd_activated', true);
	   }	   
	   function srpt_plugin_redirect() 
		{
			if( strlen( get_option( 'srpt_activation_redirect' ) ) > 0 && strlen( get_option( 'laudd_activated' ) ) > 0 && !strlen( get_option('laudd_siteid') ) > 0 ){
			
					$srpt_url = admin_url( 'tools.php?page=Register-Laudd', 'http' );
					if (get_option('srpt_activation_redirect', false))
					{
						delete_option('srpt_activation_redirect');
						wp_redirect($srpt_url);
					}
				}
		}
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	  // Creating registration page for laudd
	   function create_registration_form()
	    {
			if(!strlen(get_option('laudd_siteid'))>0)
			{
				// Registration form
				$page = add_submenu_page( 'tools.php', 'Laudd Registration ', 'Laudd Registration', 'manage_options', 'Register-Laudd', array($this,'register_laudd') );
				add_action( 'admin_print_styles-' . $page, array($this, 'register_plugin_styles' ));	
				add_action('admin_print_scripts-' . $page, array($this, 'add_plugin_scripts'));
				
				//Login Page
				$page = add_submenu_page( NULL, 'Laudd Login', 'Laudd Login', 'manage_options', 'Laudd-Login', array($this,'laudd_Login') );
				add_action( 'admin_print_styles-' . $page, array($this, 'register_plugin_styles' ));	
				add_action('admin_print_scripts-' . $page, array($this, 'add_plugin_scripts'));
			}
			
							// Thank you Page
				$page = add_submenu_page( NULL, 'Laudd Thankyou', 'Laudd Thankyou', 'manage_options', 'Laudd-Thankyou', array($this,'laudd_thankyou') );
				add_action( 'admin_print_styles-' . $page, array($this, 'register_plugin_styles' ));	
				add_action('admin_print_scripts-' . $page, array($this, 'add_plugin_scripts'));
	    }
  
  //--------------------------------------------------------------------------------------------------------------------------------------// 
   // Code for Creating Registration Menu
	   function register_laudd()
	   {	
				require_once('html/registration_form_html.php');
	   }
	   
  //--------------------------------------------------------------------------------------------------------------------------------------// 
   // Code for Creating Registration Menu
	   function laudd_thankyou()
	   {
			require_once('html/thankyou_html.php');
	   }   
	   
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	// Code to add Style Sheet In Head.
		public function register_plugin_styles()
		{	
			if( is_single() || is_admin()){
				wp_register_style( 'laudd-css', plugins_url( '/css/laudd.css', __FILE__ ) );
				wp_enqueue_style( 'laudd-css' );
			}
		}
		 
	//--------------------------------------------------------------------------------------------------------------------------------------// 
	// Code to add Scripts In Head.
		public function add_plugin_scripts()
		{	
			wp_register_script( 'laudd-js', plugins_url( '/js/laudd.js', __FILE__ ) );
			wp_enqueue_script( 'laudd-js' );
		}
		
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	// Code to add Script In Head.
		public function register_plugin_scripts()
		{
			
			if(!is_home()){
				$site_id = get_option('laudd_siteid');
				echo "<script>(function(){
								var ld = document.createElement('script');ld.type = 'text/javascript'; ld.async = true;
								ld.src = 'https://laudd.com/userv/ReIgnite?s=".$site_id."';var s = document.getElementsByTagName('script')[0];
								s.parentNode.insertBefore(ld, s);
						})();</script>";
			}
		}
		
  //--------------------------------------------------------------------------------------------------------------------------------------// 
	//Code to Run Code in Single.PHP file
		function laudd_add_to_content($content)
		{	
			$updated_content .= '<div class="laudd-toolbar" data-aspect="horizontal"></div>';
			$updated_content .= '<div class="laudd-toolbar" data-aspect="vertical"></div>';
			return @$updated_content.$content.@$auto_mark_content;
		}
	 
   //-------- Code For Creating Laudd Toolbar Setting options for Single Post ----------------------------------------------------------//
		
		// register the meta box
			function my_custom_field_checkboxes() {
				add_meta_box(
					'laudd_toolbar_id',          // this is HTML id of the box on edit screen
					'Laudd Settings',    // title of the box
					 array($this, 'laudd_setting_field'),   // function to be called to display the checkboxes, see the function below
					'post',        // on which edit screen the box should appear
					'normal',      // part of page where the box should appear
					'default'      // priority of the box
				);
			}
			
  //--------------------------------------------------------------------------------------------------------------------------------------// 
		// display the metabox
			function laudd_setting_field( $post_id ) 
			{
				global $post;
				$post_id = $post->ID;
				
				// nonce field for security check, you can have the same
				// nonce field for all your meta boxes of same plugin
				wp_nonce_field( plugin_basename( __FILE__ ), 'laudd_nonce' );
				$tool_values = get_post_meta( $post_id, 'load_toolbar', true ); 
				$auto_mark_content_value = get_post_meta( $post_id, 'auto_mark_content', true ); 
				
				$field = '';
				$field .=  '<input type="checkbox" name="load_toolbar" value="1" ';
				if($tool_values == 1 || $tool_values == '') $field.= 'checked="checked"';
				$field .='/> Allow Toolbar';
				
				$field .=  '<br /><input type="checkbox" name="auto_mark_content" value="1" ';
				if( $auto_mark_content_value == 1 ) $field.= 'checked="checked"';
				$field .='/> Do not automatically mark premium content in this post';
				
				echo $field;
			}
			
  //--------------------------------------------------------------------------------------------------------------------------------------// 
		// save data from checkboxes
			function my_custom_field_data() 
			{
				global $post;
				$post_id = $post->ID;
				
				// check if this isn't an auto save
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
					return;

				// security check
				if ( !wp_verify_nonce( $_POST['laudd_nonce'], plugin_basename( __FILE__ ) ) )
					return;

				// now store data in custom fields based on checkboxes selected
				if ( isset( $_POST['load_toolbar'] ) ){
					update_post_meta( $post_id, 'load_toolbar', '1' );
				} else {
					update_post_meta( $post_id, 'load_toolbar', '0' );
				}
					
				if ( isset( $_POST['auto_mark_content'] ) ){
					update_post_meta( $post_id, 'auto_mark_content', '1' );
				} else {
					update_post_meta( $post_id, 'auto_mark_content', '0' );
				}
			}
				
  //-------- Code End Here --------------------------------------------------------------------------------------------------------------//

  
 ################################################# Laudd Metrics Section Code Start Here ##################################################
 
    //--------------------------------------------------------------------------------------------------------------------------------------// 
	// Code to add Scripts In Head.
		public function add_calender_scripts()
		{	
			wp_register_script( 'laudd-js', plugins_url( '/js/laudd.js', __FILE__ ) );
			wp_enqueue_script( 'laudd-js' );
		}
	//--------------------------------------------------------------------------------------------------------------------------------------// 
	// Code to add Style Sheet In Head.
		public function add_calender_styles()
		{	
			wp_register_style( 'laudd-css', plugins_url( '/css/laudd.css', __FILE__ ) );
			wp_enqueue_style( 'laudd-css' );
		}
	   
 //--------------------------------------------------------------------------------------------------------------------------------------// 
   //Code to Add Custom Buttons to Editor
	   function appthemes_add_quicktags()
	   {
			if (wp_script_is('quicktags') )
			{
				$screen = get_current_screen();
				if($screen -> post_type == 'post')
				{
					/*?>
						<script type="text/javascript">
						QTags.addButton( 'id_blur', 'Mark Premium Content', '[LauddObscure]', '[/LauddObscure]', 'div', 'Appears blurred to unprivileged users', 1 );
						QTags.addButton( 'id_hide', 'Laudd-Hide', '<div class="laudd-hide">', '</div>', 'div', 'Hide Content', 2 );
						QTags.addButton( 'id_show', 'Laudd-Show', '<div class="laudd-show">', '</div>', 'div', 'Show Content', 3 );
						</script>
					<?php*/ 
				}	
			}
		}
		
  //---------------------------------------------------------------------------------------------//	   
	//Short code for Tool Bar and Obscure Div
	function laudd_toolbar()
	{
			global $post;
			$post_id = $post->ID;
			$tool_values = get_post_meta( $post_id, 'load_toolbar', true );
			$updated_content="";
			if( is_single() && ($tool_values == 1 || $tool_values == '')) 
			{
				$updated_content .= '<div class="laudd-toolbar" data-aspect="horizontal" data-button-color="white" data-spring-loaded="false" ></div>';
				$updated_content .= '<div class="laudd-toolbar" data-aspect="vertical" data-button-color="white" data-spring-loaded="false" ></div>';			
			}
			echo $updated_content.$content;
			
		
	}
	function laudd_obscure($atts, $content = null ){
		return '<div class="Laudd_blur" style="visibility:hidden;">'.$content.'</div>';
	}
	function laudd_hide($atts, $content = null ){
		return '<div class="Laudd_hide" style="visibility:hidden;">'.$content.'</div>';
	}
	
   //---------------------------------------------------------------------------------------------//	   
	//Check if Site ID is correct or not
	function check_laudd_site_id_status()
	{	
		$invalid_data = 'ew!';
		$deactivation_flag = true;
		if( isset( $_POST['site_id'] ) && $_POST['site_id']){
			$siteID = $_POST['site_id'];
			$url = "https://laudd.com/PublisherPortal/verifySiteId?s=".$siteID;
			$json = @file_get_contents($url);
			$data = json_decode($json);
			if(is_object($data)){
				if( $data->error == '' ){
					update_option( 'laudd_siteid', $siteID, 'yes' );
					$deactivation_flag = false;
					echo 1;
				} else {
					$deactivation_flag = true;
					echo $invalid_data;
				}
			} else {
				$deactivation_flag = true;
				echo $invalid_data;
			}	
		} else {
			$deactivation_flag = true;
			echo $invalid_data;
		}
		if( $deactivation_flag ){
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
		die();
	}
	//---------------------------------------------------------------------------------------------//
	  //Check if Site ID is entered or not
	  function deactivate_laudd_for_blank_site_id()
	  {
		 $screen = get_current_screen();
		 $current_page_base = $screen->base;
		 $res = array('tools_page_Register-Laudd', 'plugins');
		 if( $current_page_base != '' ){
			 if( !in_array($current_page_base, $res ) && !strlen(get_option('laudd_siteid')) > 0  ){
				deactivate_plugins( plugin_basename( __FILE__ ) );
			 }
		 }
	  }	   
}
$laudd = new Laudd();
?>
