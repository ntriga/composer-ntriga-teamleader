<?php

namespace Ntriga;

class Teamleader
{
	private $api_group;
	private $api_secret;

	function __construct($api_group, $api_secret){
		$this->api_group = $api_group;
		$this->api_secret = $api_secret;
	}

	private function make_api_call($action, $fields = array()){
		// $url will contain the API endpoint
		$url = "https://app.teamleader.eu/api/".$action;

		// $fields contains all the fields that will be POSTed
		$fields = array_merge($fields, array(
			"api_group"=>$this->api_group,
			"api_secret"=>$this->api_secret
		));

		// Make the POST request using Curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

		// Decode and display the output
		$api_output =  curl_exec($ch);
		$json_output = json_decode($api_output);
		$output = $json_output?$json_output:$api_output;

		// Clean up
		curl_close($ch);

		return $output;
	}

	public function add_front_user($user, array $tags = array(), array $options = array()){

		$mappings = array(
			'forename' => 'firstname',
			'surname' => 'name',
			'email' => 'email',
			'telephone' => 'phone',
			'country' => 'country',
			'zipcode' => 'zip',
			'city' => 'city',
			'street' => 'address',
			'number' => 'number',
		);

		$fields = array();
		if (!empty($user->email) && !empty($user->firstname) && !empty($user->name)) {
			foreach ($mappings as $tl_field => $user_field) {
				if (isset($user->{$user_field})) {
					$fields[$tl_field] = $user->{$user_field};
				}
			}
		}else{
			throw new Exception("User email, name and firstname can't be empty", 1);
		}

		$fields = array_merge($fields, $options);

		if (isset($tags[0])) {
			$fields['add_tag_by_string'] = implode(',',$tags);
		}

		return $this->make_api_call('addContact.php', $fields);
	}
}
