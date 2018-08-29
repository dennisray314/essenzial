<?php
/**
 * Created by PhpStorm.
 * User: Suzan
 * Date: 10/4/16
 * Time: 9:51 AM
 */
$miinto_country_array = array(
    array('', 'Select Country'),
    array('DK', 'Denmark'),
    array('SE', 'Sweden'),
    array('NO', 'Norway'),
    //array('ES' , 'Espain'), category tree not found
    array('NL', 'Netherlands'),
    array('PL', 'Poland'),
    array('BE', 'Belgium')
);

$country_arr = '';
//echo ("Code : " .$this->miinto_country_code);
$country_arr .= '<select name="cpf_miinto_feed_country_list" id="cpf_miinto_feed_country_list"  onchange="cpf_fetch_miinto_category(this)">';
//$country_arr .= '<option value="0"> Select Country </option>';
foreach ($miinto_country_array as $key => $value) {
    if (isset($this->miinto_country_code) && $value[0] == $this->miinto_country_code)
        $selected = 'selected';
    else
        $selected = '';
    $country_arr .= '<option value="' . $value[0] . '" ' . $selected . '>' . $value[1] . '</option>';
}
$country_arr .= '</select>';
$feed_id = isset($_GET['id']) ? isset($_GET['id']) : '';
if ($feed_id) {
    $style_1 = "style='display: block;'";
} else {
    $style_1 = "style = 'display: none;'";
}

?>
<div style="display: none;" id="ajax-loader-cat-import" ><span id="gif-message-span"></span></div>
<div class="clear"></div>
<div id="feedPageBody" class="cpf-pagebody-holder-p1" style="width: 100%; float: left;">
    <div class="attributes-mapping">
        <div id="poststuff">
            <div class="postbox">

                <!-- ***************
                        Page Header
                        ****************** -->

                <!--<div class="service_name_long hndle">
                    <h2><?php /*echo $this->service_name_long; */?></h2>
                    <a target="_blank" title="Generate Merchant Feed"
                       href="https://www.exportfeed.com/documentation/instructions-for-trial-and-new-customers/'">How to
                        Generate <?php /*echo $this->service_name_long; */?>
                        Feed</a> <?php /*if ($this->doc_link && strlen($this->doc_link) > 0) { */?>|
                        <a target='_blank' href='<?php /*echo $this->doc_link; */?>'>Find out Pre-requisites to create
                            the <?php /*echo $this->service_name_long . ' Feed'; */?></a>
                    <?php /*} */?>
                </div>-->

                <div class= "service_name_long hndle">
                    <h2>Product Feed Export for <?php echo $this->service_name; ?></h2>
                    <?php if($this->MapMerchant($this->service_name, 'how')!='') {?>
                        <a target="blank" title="Generate Merchant Feed"
                           href="https://www.exportfeed.com/documentation/instructions-for-trial-and-new-customers/'"><?php echo $this->MapMerchant($this->service_name, 'how'); ?></a> <?php if ($this->doc_link && strlen($this->doc_link) > 0) { ?>|
                            <a target=\'_blank\'
                               href='<?php echo $this->doc_link; ?>'><?php echo $this->MapMerchant($this->service_name, 'prerequisites'); ?></a>
                        <?php } }?>
                </div>


                <!-- ***************
                        LEFT SIDE
                        ****************** -->
                <!-- Attribute Mapping DropDowns -->
                <table>
                    <tr>
                        <td><h2>Please select country</h2></td>
                        <td><?php echo $country_arr; ?></td>
                    </tr>
                </table>
                <div class="inside export-target">
                <div id="shpbsc" style="display: none;" class="nav-wrapper">
                    <nav class="nav-tab-wrapper">
                        <span id="cpf-feeds_by_cats" class="nav-tab"> Feed By Category </span>
                        <span id="cpf-custom-feed" class="nav-tab"
                              onclick="return submitForm('<?php echo $this->service_name ?>');"> Custom Product Feed </span>
                    </nav>
                </div>

                <div id="custom-feed-div-kmpxr" style="display: none;">
                    <?php echo $this->loadCustomFeed(); ?>
                <div class="create-feed-container">

                    <div id="cpf_feed_right_miinto" class="feed-right" >

                        <!-- ROW 1: Local Categories -->
                        <div class="feed-right-row">
                            <span class="label">Woocommerce Category : </span>
                            <input type="text" name="local_category_display" class="text_big cpf-createpage-input" id="local_category_display" onclick="showLocalCategories('MiintoBrand')" value="<?php echo $this->miintobrandlocalcat; ?>" autocomplete="off" readonly="true" placeholder="Click here to select your categories" style="border-color: rgb(221, 221, 221);">
                            <input type="hidden" name="local_category" id="local_category" value="<?php echo $this->initial_local_category_id; ?>">
                            <span id="lcems" class="label" style="width: 25%;"></span>
                        </div>

                        <!-- ROW 2: Remote Categories -->
                        <?php echo $this->line2(); ?>
                        <div class="feed-right-row">
                            <?php echo $this->categoryList($initial_remote_category); ?>
                        </div>

                        <div id="KXTPPY">
                            <label class="attr-desc label"><span class="label" style="display: block;font-weight: 600;">If you need to modify your product feed,
                                <a onclick="show_advanced_attr(this)">click here to go to product feed customization options<span
                                            class="dashicons dashicons-arrow-down"></span></a>
                    </span></label>
                        </div>

                        <!-- Attribute Mapping DropDowns -->
                        <div class="feed-left" id="attributeMappings" style="display: none;">
                            <?php echo $this->attributeMappings(); ?>
                            <div id="cpf_advance_command_default" style="display:none;">
                    <span id="cpf_advance_command_settings">
                        <a href="#cpf_advance_command_desc"><input class="button-primary"
                                                                   title="This will open advance command information."
                                                                   style="font-weight: bold;" type="button"
                                                                   id="cpf_feed_config_link_default"
                                                                   value=" Feed Customization Options"
                                                                   onclick="toggleAdvanceCommandSectionDefault(this);"></a>
                    </span>
                                <div id="cpf_advance_section_default" style="display: none;">
                                    <div class="advanced-section-description" id="advanced_section_description_default"
                                         style="padding-left: 17px;">
                                        <p>Feed Customization option grant you more control over your feeds. They
                                            provide a way to create your own attribute, map from non-standard ones or
                                            modify and delete feed data.</p>
                                        <ul style="list-style: inherit;">
                                            <li><a target="_blank"
                                                   href="http://www.exportfeed.com/documentation/creating-attributes/#3_Creating_Defaults_using_Advanced_Commands">Creating
                                                    Default Attributes with Feed Customization option</a></li>
                                            <li><a target="_blank"
                                                   href="http://www.exportfeed.com/documentation/mapping-attributes/#3_Mapping_from_8216setAttributeDefault8217_Advanced_Commands">Mapping/Remapping
                                                    with Feed Customization option</a></li>
                                            <li>Comprehensive Feed Customization option can be found here: <a
                                                        title="mapping attributes - Feed Customization option"
                                                        href="http://docs.shoppingcartproductfeed.com/AttributeMappingv3.1.pdf"
                                                        target="_blank">More Feed Customization option</a> – *PDF
                                            </li>
                                            <li>Example:</li>
                                            <table class="adv-cmd-exmple">
                                                <tr>
                                                    <th>Command</th>
                                                    <th>Description</th>
                                                </tr>
                                                <tr>
                                                    <td>setAttributeDefault brand as "Your Store Name"</td>
                                                    <td>Sets all items to ‘Your Brand’</td>
                                                </tr>
                                                <tr>
                                                    <td>rule discount(0.95, *, p)</td>
                                                    <td>Take 95% of price (5% discount)</td>
                                                </tr>
                                                <tr>
                                                    <td>rule discount(0.95, *, s)</td>
                                                    <td>Take 95% of sale price (5% discount)</td>
                                                </tr>
                                            </table>
                                        </ul>
                                    </div>
                                    <div>
                                        <label class="un_collapse_label"
                                               title="Click to open advance command field to customize your feed"><input
                                                    class="button-primary" type="button"
                                                    id="toggleAdvancedSettingsButtonDefault"
                                                    onclick="toggleAdvancedDialogDeafult();"
                                                    value="Open Customization Commands"/></label>
                                        <label class="un_collapse_label"
                                               title="This will erase your attribute mappings from the feed."
                                               id="erase_mappings_default"
                                               onclick="doEraseMappings('<?php echo $this->service_name; ?>')"><input
                                                    class="button-primary" type="button"
                                                    value="Reset Attribute Mappings"/></label>
                                    </div>
                                </div>
                                <div class="feed-advanced" id="feed-advanced-default">
                                    <textarea <textarea class="feed-advanced-text"
                                                        id="feed-advanced-text-default"><?php echo $this->advancedSettings; ?></textarea>
                                    <?php echo $this->cbUnique; ?>
                                    <input class="button-primary" type="button" id="bUpdateSettingDefault"
                                           name="bUpdateSettingDefault"
                                           title="Update Setting will update your feed data according to the advance command enter in advance command section."
                                           value="Update Settings"
                                           onclick="doUpdateSetting('feed-advanced-text-default', 'cp_advancedFeedSetting-<?php echo $this->service_name; ?>'); return false;"/>
                                    <div id="updateSettingMsg">&nbsp;</div>
                                </div>
                            </div>
                        </div>

                        <!-- ROW 3: Filename -->
                        <div class="feed-right-row feed-section">
                            <span class="label">File name for feed : </span>
                            <span><input onclick="return ValidateFilename();" type="text" name="feed_filename"
                                         id="feed_filename_default" class="text_big input-big cpf-createpage-input"
                                         value="<?php echo $this->initial_filename; ?>"/></span>
                            <span id="mfefn" class="label"></span>
                        </div>
                        <div class="feed-right-row">
                            <label><span style="color: red">*</span> Use alpha-numeric values for the filename.<br>If
                                you use an existing file name, the file will be overwritten.</label>
                        </div>

                        <!-- ROW 4: Get Feed Button -->
                        <div class="feed-right-row">
                            <input class="button-primary" style="font-weight: bold;" type="button"
                                   onclick="doGetFeed('<?php echo $this->service_name; ?>' , this)" value="Get Feed"/>
                            <div id="feed-message-display" style="padding-top: 6px; color: red; margin:10px 0;">&nbsp;</div>
                            <div style="display: none;padding-top: 6px; color:  red; margin:10px 0;"
                                 id="feed-error-message-display">&nbsp;
                            </div>
                            <div style="display: none;padding-top: 6px; color:  blue; margin:10px 0;"
                                 id="feed-success-message-display">&nbsp;
                            </div>
                            <div style="display: none;padding-top: 6px; color:  #FF8C00; margin:10px 0;"
                                 id="warning-display-div">&nbsp;
                            </div>
                            <div id="cpf_feed_view"></div>
                            <div id="feed-error-display">&nbsp;</div>
                            <div id="feed_status__log"></div>
                            <div id="feed-status-display">&nbsp;</div>
                        </div>
                        <!-- ***************
                           Termination DIV
                           ****************** -->

                        <!--                 <div style="clear: both;">&nbsp;</div> -->

                        <!-- ***************
                                FOOTER
                                ****************** -->

                    </div>

                </div>


            </div>
        </div>

    </div>
</div>
</div>

    <script type="text/javascript">
        function showLocalCategoriesForMiintoBrand() {
            var shopID = jQuery("#edtRapidCartShop").val();
            if (shopID == null)
                shopID = "";
            var provider = 'miintobrand';
            jQuery.ajax({
                type: "post",
                url: ajaxurl,
                data: {
                    shop_id: shopID,
                    security: cpf.cpf_nonce,
                    action: cpf.action,
                    provider:provider,
                    feedpath: cmdFetchLocalCategories
                },
                success: function (res) {
                    parseFetchLocalCategories(res);
                    showLocalCategories(provider);
                }
            });
        }
    </script>


<!-- <script>
	function cpf_fetch_miinto_category(selector){
		s = selector;
		cpf_miinto_country = jQuery(selector).val();
		//console.log(provider);
		var provider = jQuery('#selectFeedType').val();
		var cmdFetchMiintoCategory = "core/ajax/wp/fetch_miinto_category.php";
		var thisDate = new Date();
		feedIdentifier = thisDate.getTime();
		jQuery.ajax({
			type : 'POST',
			url  : ajaxhost + cmdFetchMiintoCategory ,
			data : {
					country_code : cpf_miinto_country ,
					feed_identifier: feedIdentifier ,
					provider : provider
			} ,
			success : function (res) {
				jQuery("#cpf_feed_left_miinto").show();
				//jQuery("#cpf_advance_command_default").show();
				jQuery("#cpf_feed_right_miinto").find("#categoryDisplayText").val('');
				jQuery("#cpf_feed_right_miinto").find("#categoryList").hide();
			}
		});
	}


</script>


 -->