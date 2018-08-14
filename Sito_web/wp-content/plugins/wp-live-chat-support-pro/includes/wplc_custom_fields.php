<?php

add_action( "wplc_pro_update_db_hook", "wplc_custom_fields_tables" );
function wplc_custom_fields_tables(){
	global $wpdb;
	global $wplc_custom_fields;
	$wplc_custom_fields = $wpdb->prefix."wplc_custom_fields";
	$sql = "
        CREATE TABLE " . $wplc_custom_fields . " (
          id int(11) NOT NULL AUTO_INCREMENT,
          field_name varchar(700) NOT NULL,
          field_type int(11) NOT NULL,
          field_content varchar(700) NOT NULL,          
          status tinyint(1) NOT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ";

    dbDelta($sql);
}

function wplc_pro_custom_fields_page(){		

	wplc_enqueue_admin_styles();


	if ( ( isset( $_GET['wplc_action'] ) && $_GET['wplc_action'] == 'delete_custom_field' ) && isset( $_GET['fid'] ) && ( isset( $_GET['confirmed'] ) && $_GET['confirmed'] == 'true' ) ) {		

		$custom_field_id = sanitize_text_field( $_GET['fid'] );

		wplc_delete_custom_field( $custom_field_id );
	}

	if( isset( $_GET['wplc_action'] ) && $_GET['wplc_action'] == 'add_custom_field' ){

		wplc_custom_fields_add_page();		

	} else if ( isset( $_GET['wplc_action'] ) && $_GET['wplc_action'] == 'edit_custom_field' ){

		$custom_field_id = sanitize_text_field( $_GET['fid'] );

		wplc_custom_fields_edit_page( $custom_field_id );		

	} else if ( isset( $_GET['wplc_action'] ) && $_GET['wplc_action'] == 'delete_custom_field' ){

		$custom_field_id = sanitize_text_field( $_GET['fid'] );

		wplc_custom_fields_delete_page( $custom_field_id );		

	} else {

		wplc_custom_fields_display_page();

	}	

}

function wplc_custom_fields_display_page(){

	$wplc_add_button = isset($_GET['wplc_action']) ? "" : "<a href='?page=wplc-pro-custom-fields&wplc_action=add_custom_field' class='wplc_add_new_btn'>". __("Add New", 'wp-livechat') ."</a>";

	$content = "<div class='wrap'>";

	$content .= "<h2>".__('WP Live Chat Support Custom Fields', 'wp-livechat'). $wplc_add_button . "</h2>";

	global $wplc_version;

    if (intval(str_replace(".","",$wplc_version)) < 7000) {
    	echo "<div class='update-nag'>";
  			echo "<p>".__("Please ensure you are using version WP Live Chat Support 7.0.0 or newer, to allow for full functionality of custom fields.", "wplivechat")."</p>";
			echo "<a title='Update Now' href='./update-core.php' class='button button-primary'>".__("Update now" ,"wplivechat")."</a>";			
		echo "</div>";		
    }	

  	$results = wplc_get_all_custom_fields();  	
	
	$content .= "<table class=\"wp-list-table widefat fixed \" cellspacing=\"0\" style='width:98%'>";
	$content .= 	"<thead>";
  	$content .= 		"<tr>";
    $content .= 			"<th scope='col'><span>" . __("ID", "wplivechat") . "</span></th>";
    $content .= 			"<th scope='col'><span>" . __("Name", "wplivechat") . "</span></th>";
    $content .= 			"<th scope='col'>" . __("Type", "wplivechat") . "</th>";
    $content .= 			"<th scope='col'>" . __("Content", "wplivechat") . "</th>";
    $content .= 			"<th scope='col'>" . __("Status", "wplivechat") . "</th>";
    $content .= 			"<th scope='col'><span>" . __("Action", "wplivechat") . "</span></th>";
    $content .= 		"</tr>";
  	$content .= 	"</thead>";

  	
  	if($results){

  		foreach ($results as $result) {  			   		

  			$content .= "<tr>";

  			$content .= "<td>".$result->id."</td>";
  			$content .= "<td>".$result->field_name."</td>";
  			$content .= "<td>".wplc_return_custom_field_type( $result->field_type )."</td>";
  			if( $result->field_type == 0 ){
				$content .= "<td>".$result->field_content."</td>";
  			} else {
  				
  				$current_content = $result->field_content;
  				$current_content = str_replace("\\r", "", $current_content);
  				$current_content = json_decode( stripslashes( $current_content ) );
  				$content .= "<td>";
  				foreach( $current_content as $val ){
  					$content .= "<span>".$val."</span><br/>";
  				}
  				$content .= "</td>";

  			}

  			if( $result->status ){  			
  				$status_string = __("Active", "wplivechat");  		
  			} else {  				
  				$status_string = __("Inactive", "wplivechat");
  			}

  			$content .= "<td>".$status_string."</td>";
  			
  			$wplc_edit_button = "<a href='".admin_url("admin.php?page=wplc-pro-custom-fields&wplc_action=edit_custom_field&fid=".$result->id)."' class='button'>".__("Edit", "wplivechat")."</a>";
  			$wplc_delete_button = "<a href='".admin_url("admin.php?page=wplc-pro-custom-fields&wplc_action=delete_custom_field&fid=".$result->id)."' class='button'>".__("Delete", "wplivechat")."</a>";
  			
  			$content .= "<td>$wplc_edit_button $wplc_delete_button</td>";

  			$content .= "</tr>";

  		}

  	} else {

  		$content .= "<tr><td colspan='7'>".__("Create your first custom field", "wplivechat")."</td></tr>";

  	}

  	$content .= 	"</table>";

  	$content .= "</div>";

	echo $content;

}

function wplc_custom_fields_add_page(){

	global $wpdb;

	$content = "";
	$content .= "<div class='wrap'>";
	$content .= "	<h2>".__("Create a Custom Field", "wplivechat")."</h2>";
	$content .= "	<form method='POST'>";
	$content .= "	<table class='wp-list-table widefat fixed wpgmza-listing'>";		
	$content .= "		<tbody>";
	$content .= "			<tr>";
	$content .= "				<td>".__('Field Name', 'wp-google-maps')."</td>";
	$content .= "				<td><input type='text' name='wplc_field_name' id='wplc_field_name' style='width: 250px;'/></td>";
	$content .= "			</tr>";
	$content .= "			<tr>";
	$content .= "				<td>".__('Field Type', 'wp-google-maps')."</td>";
	$content .= "				<td>";
	$content .= "					<select name='wplc_field_type' id='wplc_field_type' style='width: 250px;'>";
	$content .= "						<option value='0'>".__("Text", "wplivechat")."</option>";
	$content .= "						<option value='1'>".__("Drop Down", "wplivechat")."</option>";
	$content .= "					</select>";
	$content .= "				</td>";
	$content .= "			</tr>";	
	$content .= "			<tr id='wplc_field_value_row'>";
	$content .= "				<td>".__('Default Field Value', 'wp-google-maps')."</td>";
	$content .= "				<td><input type='text' name='wplc_field_value' id='wplc_field_value' style='width: 250px;'/></td>";
	$content .= "			</tr>";
	$content .= "			<tr id='wplc_field_value_dropdown_row' style='display: none;'>";
	$content .= "				<td>".__('Drop Down Contents', 'wp-google-maps')."</td>";
	$content .= "				<td><textarea name='wplc_drop_down_values' id='wplc_drop_down_values' rows='6' style='width: 250px;'></textarea><br/><small>".__("Enter each option on a new line", "wplivechat")."</small></td>";
	$content .= "			</tr>";
	$content .= "			<tr>";
	$content .= "				<td></td>";
	$content .= "				<td><input type='submit' class='button button-primary' name='wplc_create_custom_field' value='".__('Create Custom Field', 'wp-google-maps')."' /></td>";
	$content .= "			</tr>";
	$content .= "		</tbody>";
	$content .= "	</table>";
	$content .= "	</form>";
	$content .= "</div>";
	echo $content;
}	

function wplc_custom_fields_edit_page( $id ){

	global $wpdb;
	$wplc_custom_fields_table = $wpdb->prefix."wplc_custom_fields";

	$id = sanitize_text_field( $id );
	
	$sql = "SELECT * FROM $wplc_custom_fields_table WHERE `id` = $id";

	$result = $wpdb->get_row( $sql );

	if($result){
		$field_content = $result->field_content;

		if( $result->field_type == 1) {
			$field_content = str_replace("[", "", $field_content);
			$field_content = str_replace("\\r", "\n", $field_content);
			$field_content = str_replace("\\n", "\n", $field_content);
			$field_content = str_replace("\"", "", $field_content);
			$field_content = str_replace(",", "", $field_content);
			$field_content = str_replace("]", "", $field_content);
		}

		$content = "";
		$content .= "<div class='wrap'>";
		$content .= "	<h2>".__("Edit a Custom Field", "wplivechat")."</h2>";
		$content .= "	<form method='POST'>";
		$content .= "	<table class='wp-list-table widefat fixed wpgmza-listing'>";		
		$content .= "		<tbody>";
		$content .= "			<tr>";
		$content .= "				<td>".__('Field Name', 'wp-google-maps')."</td>";
		$content .= "				<td><input type='text' name='wplc_field_name' id='wplc_field_name' style='width: 250px;' value='".$result->field_name."'/></td>";
		$content .= "			</tr>";
		$content .= "			<tr>";
		$content .= "				<td>".__('Default Field Value', 'wp-google-maps')."</td>";
		$content .= "				<td><input type='text' name='wplc_field_value' id='wplc_field_value' style='width: 250px;' value='".$field_content."'/></td>";
		$content .= "			</tr>";
		$content .= "			<tr>";
		$content .= "				<td>".__('Field Type', 'wp-google-maps')."</td>";
		$content .= "				<td>";
		$content .= "					<select name='wplc_field_type' id='wplc_field_type' style='width: 250px;'>";
											if( $result->field_type == 0 ) { $sel = 'selected'; } else { $sel = ''; }
											if( $result->field_type == 1 ) { $sel1 = 'selected'; } else { $sel1 = ''; }
		$content .= "						<option value='0' $sel>".__("Text", "wplivechat")."</option>";
		$content .= "						<option value='1' $sel1>".__("Drop Down", "wplivechat")."</option>";
		$content .= "					</select>";
		$content .= "				</td>";
		$content .= "			</tr>";	
		$content .= "			<tr>";
		$content .= "				<td>".__('Drop Down Contents', 'wp-google-maps')."</td>";
		$content .= "				<td><textarea name='wplc_drop_down_values' id='wplc_drop_down_values' rows='6' style='width: 250px;'>".$field_content."</textarea><br/><small>".__("Enter each option on a new line", "wplivechat")."</small></td>";
		$content .= "			</tr>";
		$content .= "			<tr>";
		$content .= "				<td></td>";
		$content .= "				<td><input type='submit' class='button button-primary' name='wplc_update_custom_field' value='".__('Update Custom Field', 'wp-google-maps')."' /></td>";
		$content .= "			</tr>";
		$content .= "		</tbody>";
		$content .= "	</table>";
		$content .= "	</form>";
		$content .= "</div>";
	} else {
		$content = "";
		$content .= "<div class='wrap'>";
		$content .= "	<h2>".__("Custom Field Not Found", "wplivechat")."</h2>";
		$content .= "	<a href='". admin_url("admin.php?page=wplc-pro-custom-fields")."' class='button button-primary'>".__("Back", "wplivechat")."</a>";
		$content .= "</div>";
	}
	echo $content;

}

function wplc_custom_fields_delete_page( $id ){

	$content = "";

	$content .= "<div class='error'>";
	$content .= "<p>".__("Are you sure you want to delete this custom field?", "wplivechat")."</p>";
	$content .= "<p><a href='".admin_url("admin.php?page=wplc-pro-custom-fields&wplc_action=delete_custom_field&fid=$id&confirmed=true")."'>".__("Yes", "wplivechat")."</a> | <a href='".admin_url("admin.php?page=wplc-pro-custom-fields")."'>".__("No", "wplivechat")."</a></p>";
	$content .= "</div>";

	echo $content;

}

function wplc_delete_custom_field( $id ){
	global $wpdb; 
	$wplc_custom_fields_table = $wpdb->prefix."wplc_custom_fields";

	$id = intval( $id );

	$wpdb->delete( $wplc_custom_fields_table, array( 'id' => $id ), array( '%d' ) );

	?><script>window.location = "<?php echo admin_url( 'admin.php?page=wplc-pro-custom-fields' ); ?>" </script><?php
}

function wplc_get_all_custom_fields(){
	global $wpdb;
	$wplc_custom_fields = $wpdb->prefix."wplc_custom_fields";

	$sql = "SELECT * FROM $wplc_custom_fields";

	$results = $wpdb->get_results( $sql );

	return $results;
}

function wplc_return_custom_field_type( $type ){

	$type = intval( $type );

	switch( $type ){
		case 0:
			$val = __("Text Field", "wplivechat");
			break;
		case 1:
			$val = __("Dropdown", "wplivechat");
			break;
		default:
			$val = __("Unknown", "wplivechat");
			break;
	}

	return $val;

}

add_filter( "wplc_start_chat_user_form_after_filter", "wplc_display_custom_fields_in_chatbox", 11, 2 );

function wplc_display_custom_fields_in_chatbox( $string ){	
	
	$ret = "<p>";

	$custom_fields = wplc_get_all_custom_fields();

	if( $custom_fields ){

		foreach( $custom_fields as $field ){

			if( $field->field_type == 0 ){				
				
				$ret .= "<input type='text' name='wplc_custom_field[".$field->id."]' id='wplc_custom_field_".$field->id."' fname='".$field->field_name."' placeholder='".$field->field_name."' value='".$field->field_content."' />";
			
			} else if( $field->field_type == 1 ){
			
				$ret .= "<select name='wplc_custom_field[".$field->id."]' id='wplc_custom_field_".$field->id."' fname='".$field->field_name."'>";
				$content = $field->field_content;
				$content = str_replace("\\r", "", $content);
				$options = json_decode( $content );				

				if( $options ){
					foreach( $options as $key => $val ){
						$ret .= "	<option value='$val'>".trim( $val )."</option>";
					}
				}

				$ret .= "</select>";

			}

		}

	}
	$ret .= "</p>";

	return $string . $ret;
}

add_filter( "wplc_filter_advanced_info", "wplc_advanced_info_custom_fields", 10, 2 );

function wplc_advanced_info_custom_fields( $string, $cid ){
	$extra_data = "";
	$content = "";

	$chat_data = wplc_get_chat_data( $cid, __LINE__ );
	if( $chat_data->other ){
		$extra_data = maybe_unserialize( $chat_data->other );

		if( $extra_data && isset( $extra_data['wplc_extra_data'] ) && isset( $extra_data['wplc_extra_data']['custom_fields'] ) ) {

			$content .= "<br/><div class='admin_visitor_advanced_info admin_agent_rating'>";
			$content .= "<strong>".__("Custom Field Data", "wplivechat")."</strong>";
			$content .= "<hr>";
			$the_extra_data = maybe_unserialize( $extra_data['wplc_extra_data']);
			$the_extra_data = json_decode( stripslashes( $extra_data['wplc_extra_data']['custom_fields'] ) );

			if( $the_extra_data ){
				foreach( $the_extra_data as $data ){
					$content .= "<span class='part1'>".$data->{0}.":</span> <span class='part2'>".$data->{1}."</span><br/>";
				}
			}
		}
	}

	$content .= "</div>";

	return $string . $content;
	
}

add_action( "admin_head", "wplc_custom_fields_admin_head" );

function wplc_custom_fields_admin_head(){

	global $wpdb;
	$custom_field_table = $wpdb->prefix."wplc_custom_fields";

	if( ( isset( $_POST['wplc_create_custom_field'] ) || ( isset( $_POST['wplc_update_custom_field'] ) && isset( $_GET['fid'] ) ) ) ){

		$field_name = sanitize_text_field( $_POST['wplc_field_name'] );
		
		$field_type = sanitize_text_field( $_POST['wplc_field_type'] );

		$field_id = intval( sanitize_text_field( $_GET['fid'] ) );

		if( isset( $_POST['wplc_drop_down_values'] ) && $_POST['wplc_drop_down_values'] != "" && $field_type == 1){

			$dropdown_contents = $_POST['wplc_drop_down_values'];		

			$field_value = explode( "\n", $dropdown_contents );

			$field_value = json_encode( $field_value );

		} else {

			$field_value = sanitize_text_field( $_POST['wplc_field_value'] );
			
		}

		if ( isset( $_POST['wplc_create_custom_field'] ) ) {
			$wpdb->insert(
				$custom_field_table,
				array(
					'field_name' 	=> $field_name,
					'field_type' 	=> $field_type,
					'field_content'	=> $field_value,
					'status'		=> 1
				),
				array(
					'%s',
					'%s',
					'%s',
					'%d',
				)
			);
		} else if ( isset( $_POST['wplc_update_custom_field'] ) ) {
			$wpdb->update(
				$custom_field_table,
				array(
					'field_name' 	=> $field_name,
					'field_type' 	=> $field_type,
					'field_content'	=> $field_value,
					'status'		=> 1
				),
                array( 'id' => $field_id ),
				array(
					'%s',
					'%s',
					'%s',
					'%d',
				),
                array( '%d' )
			);
        }

		?><script>window.location = "<?php echo admin_url( 'admin.php?page=wplc-pro-custom-fields' ); ?>" </script><?php

	}

}


add_filter("wplc_start_chat_hook_other_data_hook", "wplc_custom_fields_start_chat_other_data_hook", 15, 1);

function wplc_custom_fields_start_chat_other_data_hook($other_data){
	if(isset($_POST['wplc_extra_data']) && isset($_POST['wplc_extra_data']['custom_fields'])){
		$other_data['wplc_extra_data']['custom_fields'] = $_POST['wplc_extra_data']['custom_fields'];
	}
	return $other_data;
}
