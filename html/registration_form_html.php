<div id="ustat-loding" style="display:none;" class="loading-gif-img"><img src="<?php echo plugins_url( '../images/ajax-loader.gif', __FILE__ ) ?>"></div>
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
	<div class="l_error message" style="display:none;">
     <h3>Oops, an error ocurred</h3>
     <p>This is just an error notification message.</p>
	</div>
	
    <div class="content">
    	<div class="container">
        	<div class="content-inner">            	
                               <div class="lt-cont">
                	<div class="heading">Viralize Your Website!&#8482;</div>
                    <div class="reg-points">
                    	<ul>
                        	<li>
                            	<div class="icon">
                                	<img src="<?php echo plugins_url( '../images/share-icon.png', __FILE__ ) ?>" alt="img">
                                </div>
                                <div class="icon-text">
                                	<div class="icon-heading">
                                    	Motivate users to share your content
                                    </div>
                                    <div class="icon-txt">
                                    	Only the Laudd sharing toolbar offers your users points by sharing your content on Facebook, Twitter or LinkedIn. <br> Users can use points to view premium content anywhere on the internet.
                                    </div>
                                </div>
                            </li>                           
                            <li>
                            	<div class="icon">
                                	<img src="<?php echo plugins_url( '../images/content-icon.png', __FILE__ ) ?>" alt="img">
                                </div>
                                <div class="icon-text">
                                	<div class="icon-heading">
                                    	Define premium content items
                                    </div>
                                    <div class="icon-txt">
                                    	Only Laudd offers you an easy way to define premium items on pages accessible to all. You can mark items such as interactive features, infographics, images, videos or even text as premium.
                                    </div>
                                </div>
                            </li>                           
                            <li>
                            	<div class="icon">
                                	<img src="<?php echo plugins_url( '../images/traffic-icon.png', __FILE__ ) ?>" alt="img">
                                </div>
                                <div class="icon-text">
                                	<div class="icon-heading">
                                    	Increase traffic and reach
                                    </div>
                                    <div class="icon-txt">
                                    	Because Laudd offers your user points for sharing, you instantly see dramatically increased website traffic from social networks. The higher social presence also means lots of new users!
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
				<?php if(strlen(get_option('laudd_siteid')) == 0 ) {?>
					 <div id="laudd_user_registration">
					   <div class="rt-cont">
						   <div class="get-txt">Activate the Laudd WordPress Plugin</div>
						   <div class="reg-instr">
							<p>In order to activate the Laudd Plugin, you need to have registered your WordPress website by going to <a href="https://laudd.com" target="_blank" >https://laudd.com</a></p>
							<p>Once you register your website there, you will see a "Site Id" in the configuration page. Enter that Site Id below:</p>
						   </div>
						   <div class="form">
						     <form name="laudd-register" method="post" action="" onsubmit="return validate();">
									<input type="text" placeholder="Copy and paste the Site Id here" name="site_id" id="laudd_site_id">
									<input type="hidden" name="redirect-page" id="thanks-redirect-page" value="<?php echo admin_url("tools.php?page=Laudd-Thankyou") ?>" />
									<input type="hidden" name="redirect-cancel-url" id="redirect-cancel-url" value="<?php echo admin_url("plugins.php") ?>" />
									<input type="submit" value="Submit"  name="submit_site_id" id="submit_site_id" />
							 </form>
						   </div> 
					   </div>
					</div>
			
				<?php } else {?>
				<script>laudd_redirect('<?php echo admin_url("tools.php?page=Laudd-Thankyou") ?>');</script>
				<?php }?>
            </div>
        </div>
    </div>
</div>

