<?php

/**
* This is a placeholder controller that may be overridden differently in each application,
* and includes a suggested method, my() which shows the current user's profile, and is a good place to
* place a form to edit Profile, User and any other models related to Profile in one place
*/

class ProfilesController extends UsersAppController {

	function my() {
		if(empty($this->data)) {
			$this->data = $this->Profile->findByUserId($this->Auth->user('id'));
			if(empty($this->data)) {
				$this->_smartFlash(__('User profile not found.',true),'/');
			}
		} else {
			$fieldList = array('first_name','last_name','email');
			if(Configure::read('User.profileSaveWhitelist')) {
				$fieldList = Configure::read('User.profileSaveWhitelist');
			}
			if($this->Profile->saveAll($this->data, array('fieldList'=>$fieldList,'validate'=>'first'))) {
				$this->Session->setFlash('Profile updated.');
			} else {
				$this->Session->setFlash(__('Could not update profile.',true));
			}
		}
		$result = $this->Profile->findByUserId($this->Auth->user('id'));
		$this->set('data',$result);
	}
	
}

?>