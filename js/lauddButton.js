jQuery(window).load(function() {
	
/*-----------------Mark Premium Content Button Enable/Disable function depending on content selection ------------------- */ 	
		setInterval(function(){
		if (jQuery("#wp-content-wrap").hasClass("tmce-active"))
			{
				var _val = tinyMCE.activeEditor.selection.getContent();
				if(_val != '')
				{				
					jQuery('#Laudd_Obscure').removeAttr('disabled');
					jQuery("#Laudd_Obscure").attr("title", "Appears blurred to unprivileged users");					
				}
				else
				{
					jQuery('#Laudd_Obscure').attr("disabled","disabled");
					jQuery("#Laudd_Obscure").attr("title", "You can mark premium content after selecting content in the editor. Select content in the editor first");
				}
				
			}
			else
			{
				var textarea = document.getElementById("content");
				if (textarea.selectionStart != textarea.selectionEnd) {
				
				}
				else{
					jQuery('#Laudd_Obscure').attr("disabled","disabled");
					jQuery("#Laudd_Obscure").attr("title", "You can mark premium content after selecting content in the editor. Select content in the editor first");
				}
			}
			
		},1000);	
			
		jQuery("#content").select(function()
		{
				var textarea = document.getElementById("content");
				if (textarea.selectionStart != textarea.selectionEnd) {
					jQuery('#Laudd_Obscure').removeAttr('disabled');
					jQuery("#Laudd_Obscure").attr("title", "Appears blurred to unprivileged users");
				}
		});
/*-----------------Add Caption Button Enable/Disable function ------------------- */ 	
		
		jQuery('#caption-text').keyup(function(){
			var text= document.getElementById("caption-text").value;
			if(text=='')
			{
			
			jQuery('#ok').attr("disabled","disabled");
			jQuery('#ok').addClass("ok-disable");
			jQuery('#ok').removeClass("ok");
			}
			else{
			jQuery('#ok').removeAttr('disabled');
			jQuery('#ok').removeClass("ok-disable");
			jQuery('#ok').addClass("ok");
			}
		
		});
		
		jQuery('#qt_content_id_blur').addClass('masterTooltip');
		
	/*-----------------Mark Premium Content Button function ------------------- */   
		jQuery('#Laudd_Obscure').click(function(){
		if (jQuery("#wp-content-wrap").hasClass("tmce-active"))
			{
				
				var _val = tinyMCE.activeEditor.selection.getContent();
				if(_val != '')
				{
					
					jQuery('#pop-laudd-main').show();									
				}
				
			}
			else{
				var textarea = document.getElementById("content");
				if (textarea.selectionStart != textarea.selectionEnd) {
					jQuery('#pop-laudd-main').show();	
				}							
			}  
		});
			
	/*-------- Mark Premiun Content Ok Button Click Function------------ */
		jQuery('#dialog-pc-caption').find('#ok').click(function(){			
			var caption = jQuery('#dialog-pc-caption textarea').val();
			var caption_wrapper = "";
			if(caption != '')
			{
				caption_wrapper = "[LauddHide]"+ caption +"[/LauddHide]";				
			}
			if(jQuery("#wp-content-wrap").hasClass("tmce-active"))		
			{
				var _val = tinyMCE.activeEditor.selection.getContent();		
				tinyMCE.activeEditor.selection.setContent(caption_wrapper + '[LauddObscure]'+_val+'[/LauddObscure]');
			}
			else
			{ 
					var textarea = document.getElementById("content");
					if('selectionStart' in textarea) {
							// check whether some text is selected in the textarea
						if(textarea.selectionStart != textarea.selectionEnd) {
							var newText = textarea.value.substring(0, textarea.selectionStart)+caption_wrapper+'[LauddObscure]'+textarea.value.substring(textarea.selectionStart, textarea.selectionEnd)+'[/LauddObscure]'+textarea.value.substring(textarea.selectionEnd);
							textarea.value = newText;
						}
					}
					else {  // Internet Explorer before version 9
							// create a range from the current selection
						var textRange = document.selection.createRange ();
							// check whether the selection is within the textarea
						var rangeParent = textRange.parentElement ();
						if(rangeParent === textarea) {
							textRange.text = caption_wrapper+'[LauddObscure]'+textRange.text+'[/LauddObscure]';
						}
					}
			}
			jQuery('#dialog-pc-caption textarea').val('');
			//jQuery('#dialog-pc-caption').hide();
			jQuery('#pop-laudd-main').hide();	
			return false;
		});
		
	/* -------- Mark Premiun Content Cancel Button Click Function ------------ */
		jQuery('#dialog-pc-caption').find('#cancel').click(function(){
			jQuery('#dialog-pc-caption textarea').val('');
			//jQuery('#dialog-pc-caption').hide();
			jQuery('#pop-laudd-main').hide();
			if(jQuery("#wp-content-wrap").hasClass("tmce-active"))		
			{
				var _val = tinyMCE.activeEditor.selection.getContent();
				tinyMCE.activeEditor.selection.setContent('[LauddObscure]'+_val+'[/LauddObscure]');
			}
			else
			{ 
					var textarea = document.getElementById("content");
					if('selectionStart' in textarea) {
							// check whether some text is selected in the textarea
						if(textarea.selectionStart != textarea.selectionEnd) {
							var newText = textarea.value.substring(0, textarea.selectionStart)+'[LauddObscure]'+textarea.value.substring(textarea.selectionStart, textarea.selectionEnd)+'[/LauddObscure]'+textarea.value.substring(textarea.selectionEnd);
							textarea.value = newText;
						}
					}
					else {  // Internet Explorer before version 9
							// create a range from the current selection
						var textRange = document.selection.createRange ();
							// check whether the selection is within the textarea
						var rangeParent = textRange.parentElement ();
						if(rangeParent === textarea) {
							textRange.text = '[LauddObscure]'+textRange.text+'[/LauddObscure]';
						}
					}
			}
		});
	
	/* -------- Mark Premiun Content Example Button Click Function ------------ */
		jQuery('#dialog-pc-example').click(function(){
			jQuery('#dialog-pc-eg').show();
			jQuery("#dialog-pc-caption").hide();
			
		})
		
		/* -------- Mark Premiun Content Example 'OK' Button Click Function ------------ */
		jQuery('#eg-ok').click(function(){
			jQuery('#dialog-pc-eg').hide();
			jQuery("#dialog-pc-caption").show();
		})
		
		

	/*------------- Code For Tooltip --------- */
		jQuery('.masterTooltip').hover(function(){
					// Hover over code
					var title = jQuery(this).attr('title');
					jQuery(this).data('tipText', title).removeAttr('title');
					jQuery('<p class="tooltip"></p>')
					.text(title)
					.appendTo(jQuery(this).parent('div'))
					.fadeIn('slow');
			}, function() {
					// Hover out code
					jQuery(this).attr('title', jQuery(this).data('tipText'));
					jQuery('.tooltip').remove();
			}).mousemove(function(e) {
				
		});
	
	/*------------- Dialog-pc hide on esc key press --------- */
		jQuery(document).keyup(function(e) {
			if (e.keyCode == 27) 
			{
				if(jQuery("#dialog-pc-caption").is(":visible")) 
				{
					jQuery("#pop-laudd-main").hide();
				}
				if(jQuery("#dialog-pc-eg").is(":visible")) 
				{
					jQuery("#dialog-pc-caption").show();
					jQuery("#dialog-pc-eg").hide();
				}
			}
		});
	/*------------- Dialog-pc hide By outside click --------- */			
		jQuery(document).mouseup(function (e)
		{
				var container = jQuery("#dialog-pc-caption");
				var buttons = jQuery("#Laudd_Obscure");
				var example = jQuery("#dialog-pc-eg");
				

				if (!container.is(e.target) && container.has(e.target).length === 0  && !buttons.is(e.target) && !example.is(e.target) && example.has(e.target).length === 0)
				{
					if(jQuery("#dialog-pc-caption").is(":visible")) 
					{
						jQuery("#pop-laudd-main").hide();
					}
					if(jQuery("#dialog-pc-eg").is(":visible")) 
					{
						container.show();
						example.hide();
					}
				}
		});
		
	/*------------- Dialog-pc hide on cancel button click --------- */	
		jQuery("#new_cancel").click(function(e) {
			jQuery("#pop-laudd-main").hide();
		});
			
	/* ------------- End Here ------------------ */	
});	