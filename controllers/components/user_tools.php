<?php

class UserToolsComponent extends Object {
	
	function generatePassword($options = array()) {
		$defaults = array(
			'length'=>6,
			'possible'=>'0123456789bcdfghjkmnpqrstvwxyz'
		);
		$settings = am($defaults,$options);

		$password = "";
		$i = 0; 
		while ($i < $settings['length']) { 
			$char = substr($settings['possible'], mt_rand(0, strlen($settings['possible'])-1), 1);
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}
	
}

?>