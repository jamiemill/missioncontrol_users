<?php

/**
* So far only generates passwords but I see a lot of scope for this, including perhaps moving 
* user registration and all kinds of user-related stuff out of controllers into here later
*/

require_once(APP.'missioncontrol_plugins'.DS.'core'.DS.'tests'.DS.'cases'.DS.'abstract'.DS.'mission_control_test_case.php');

App::import('component','Users.UserTools');

class UserToolsComponentTestCase extends MissionControlTestCase {
	
	function startCase() {
		$this->UserTools = new UserToolsComponent();
	}
	
	function testUserToolsIsAnObject() {
		$this->assertIsA($this->UserTools, 'Object');
	}
	
	function testGeneratePassword() {
		$password = $this->UserTools->generatePassword(array('length'=>6));
		$this->assertTrue(strlen($password), 6);
	}
	
	
}

?>