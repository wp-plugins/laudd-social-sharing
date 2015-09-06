
<?php
	if(strlen(get_option('laudd_siteid_old'))>0 && isset($_REQUEST['Reset-data']))
	{
			$laudd_registered = get_option('laudd_registered_old');
			$laudd_domain 	  = get_option('laudd_domain_old');
			$laudd_siteid 	  = get_option('laudd_siteid_old');
			$laudd_fb		  = get_option('laudd_fb_old');
			$laudd_tw		  = get_option('laudd_tw_old');
			$laudd_li 		  = get_option('laudd_li_old');
			$laudd_gp		  = get_option('laudd_gp_old');
			
			update_option('laudd_registered', $laudd_registered);
			update_option('laudd_domain', $laudd_domain );
			update_option('laudd_siteid', $laudd_siteid );
			update_option('laudd_fb', $laudd_fb);
			update_option('laudd_tw', $laudd_tw);
			update_option('laudd_li', $laudd_li );
			update_option('laudd_gp', $laudd_gp);
			
			delete_option('laudd_registered_old');
			delete_option('laudd_domain_old');
			delete_option('laudd_siteid_old');
			delete_option('laudd_fb_old');
			delete_option('laudd_tw_old');
			delete_option('laudd_li_old');
			delete_option('laudd_gp_old');
			echo "<script>location.reload();</script>";
	}
?>
<?php  if(strlen(get_option('laudd_siteid')) != 0 ){ ?>
<input type="hidden" id="admin_url" value=""  />
<input type="hidden" id="plugin_url" value="<?php echo plugins_url('../', __file__); ?>" />
<div class="wrapper laudd-html">    
    <div class="header">
        <div class="container">
            <div class="header-inner">
                <div class="logo">
                    <img src="<?php echo plugins_url( '../images/logo.png', __FILE__ ) ?>" alt="img">
                </div>
            </div>
        </div>      
    </div>  
      <div class="content" style="margin-top:0px;">
        <div class="container">
                  <div class="l_success message" style="margin-bottom:100px;">
					 <h3>Activation Successful!</h3>
					 <p>The Laudd WordPress plugin is now active. The Laudd toolbar will now appear on all pages except the home page.</p>			
					<div class="btn-cont">
						<a href="<?php echo admin_url( 'edit.php' ); ?>" class="thanks-btn">OK</a>
					</div>
						</div>
				</div>
           
        </div>
    </div> 
</div>
<!--------------------------------------------------------------------------------------------------------------->
<?php  } ?>