<?php
function wplc_api_is_typing(WP_REST_Request $request){
	$return_array = array();
	if(isset($request)){
		if(isset($request['security'])){
			$check_token = get_option('wplc_api_secret_token');
			if($check_token !== false && $request['security'] === $check_token){
				if(isset($request['cid'])){
					if(isset($request['user'])){
						if(isset($request['type'])){
							if (wplc_typing($request['user'],sanitize_text_field($request['cid']),sanitize_text_field($request['type']))) {
								
								$return_array['response'] = "Successful";
								$return_array['code'] = "200";
								$return_array['data'] = array("cid" => intval($request['cid']),
															  "user" => intval($request['user']),
															  "type" => intval($request['type']));
							} else {
								$return_array['response'] = "Failed to send typing indicaator";
								$return_array['code'] = "401";
								$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
															      "cid"   => "Chat ID",
															      "user"   => "User type",
															      'type' => "TYPE");

							}
						} else {

						$return_array['response'] = "No 'type' found";
						$return_array['code'] = "401";
						$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
													      "cid"   => "Chat ID",
													      "user"   => "User type",
													      'type' => "TYPE");
						}

				 	} else {
						$return_array['response'] = "No 'user' found";
						$return_array['code'] = "401";
						$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
													      "cid"   => "Chat ID",
													      "user"   => "User type",
													      'type' => "TYPE");
					}
			 	} else {
					$return_array['response'] = "No 'cid' found";
					$return_array['code'] = "401";
					$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
												      "cid"   => "Chat ID",
												      "user"   => "User type",
												      'type' => "TYPE");
				}
		 	} else {
				$return_array['response'] = "Nonce is invalid";
				$return_array['code'] = "401";
			}
		} else{
			$return_array['response'] = "No 'security' found";
			$return_array['code'] = "401";
			$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
										      "cid"   => "Chat ID",
										      "user"   => "User type",
										      'type' => "TYPE");
		}
	}else{
		$return_array['response'] = "No request data found";
		$return_array['code'] = "400";
		$return_array['requirements'] = array("security" => "YOUR_SECRET_TOKEN",
									      "cid"   => "Chat ID",
									      "user"   => "User type",
									      'type' => "TYPE");
	}
	
	return $return_array;
}