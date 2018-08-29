<?php global $pfcore; ?>
<script type="text/javascript">
jQuery( document ).ready(function() {		
		var shopID = jQuery("#edtRapidCartShop").val();
		if (shopID == null)
			shopID = "";
		var template = jQuery("#remote_category").val();
		if (template != null && template.length > 0) {
			jQuery.ajax({
				type: "post",
				url: ajaxhost + cmdFetchTemplateDetails,
				data: {shop_id: shopID, template: template, provider: "amazonsc"},
				success: function(res){
					jQuery("#attributeMappings").html(res);
				}
			});
		}
	});
</script>
<div class="attributes-mapping">
	<div id="poststuff">
		  <div class="postbox">

			<!-- *************** 
					Page Header 
					****************** -->
		  <div class= "service_name_long hndle">

			<h3 class="hndle"><?php echo $this->service_name_long; ?></h3>

			<div class="">

					<br/>
					<br>

					<div class='amazon-template-table'>
						<?php echo $this->plugin_message.' '; ?>
						<a class="button-primary" target="_blank" href="<?php echo $this->plugin_url; ?>">Get Amazon Plugin Here
						</a>
						
					</div>
					
					
		   </div>

				<!-- *************** 
						Termination DIV
						****************** -->

				<div style="clear: both;">&nbsp;</div>

				<!-- *************** 
						FOOTER
						****************** -->

				


			
			</div>
		</div>
		</div>
	</div>
</div>
<script>
	function toggleAdvanceCommandSection(event){
		var feed_config =jQuery("#cpf_custom_feed_config").css('display');
		var feed_config_button = jQuery("#cpf_feed_config_link");

		//First slideUp feed config section if displayed
		if(feed_config == "block"){
			jQuery("#cpf_custom_feed_config").slideUp();
			jQuery("#cpf_feed_config_desc").slideUp();
			jQuery(feed_config_button).attr('title' , 'This will open feed config section below.You can provide suffix and prefix for the attribute to be included in feed.');
			jQuery(feed_config_button).val('Show Feed Config');
		}

		var display =jQuery("#cpf_advance_section").css('display');
		if(display == 'none'){
			jQuery("#cpf_advance_section").slideDown();
			jQuery(event).val('Hide Advance Section');
			jQuery(event).attr('title' , 'Hide Feed config section');
			/* var divPosition = jQuery("#cpf_custom_feed_config").offset();
			 jQuery('#custom_feed_settingd').animate({scrollBottom: divPosition.top}, "slow");*/
		}
		if(display == 'block'){
			jQuery("#cpf_advance_section").slideUp();
			jQuery("#feed-advanced").slideUp();
			// jQuery("#bUpdateSetting").slideUp();
			jQuery(event).attr('title' , 'This will open feed advance command section where you can customize your feed using advanced command.');
			jQuery(event).val('Feed Customization Options');
		}
	}

	function toggleAdvanceCommandSectionDefault(event){
		var display =jQuery("#cpf_advance_section_default").css('display');
		if(display == 'none'){
			jQuery("#cpf_advance_section_default").slideDown();
			jQuery(event).val('Hide Advance Section');
			jQuery(event).attr('title' , 'Hide Feed config section');
			/* var divPosition = jQuery("#cpf_custom_feed_config").offset();
			 jQuery('#custom_feed_settingd').animate({scrollBottom: divPosition.top}, "slow");*/
		}
		if(display == 'block'){
			jQuery("#cpf_advance_section_default").slideUp();
			jQuery("#feed-advanced-default").slideUp();
			// jQuery("#bUpdateSetting").slideUp();
			jQuery(event).attr('title' , 'This will open feed advance command section where you can customize your feed using advanced command.');
			jQuery(event).val('Feed Customization Options');
		}
	}
</script>