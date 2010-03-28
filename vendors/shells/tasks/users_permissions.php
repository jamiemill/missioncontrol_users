<?php

class UsersPermissionsTask extends Shell {
	
	/**
	* Will hold a reference to the Aro model
	*/
	
	var $Aro;
	
	/**
	* Will hold a reference to the Acl component
	*/
	
	var $Acl;
	
	/**
	* This method should be filled with stuff like this:
	* $this->Acl->deny(array('model'=>'Group','foreign_key'=>3),'controllers/Accounts');
	* $this->Acl->allow(array('model'=>'Group','foreign_key'=>3),'controllers/Accounts/edit');
	* 
	* You can also give some feedback to the screen with:
	* $this->out(__('Working hard...', true));
	* 
	* TODO: split these declarations out into tasks within each appropriate plugin, 
	* e.g. CorePermissionsTask, NewsPermissionsTask and get PermissionsShell to auto-include them before this file.
	*/

	function execute() {	
		
		$this->allow(array('model'=>'Group','foreign_key'=>USER_GROUP_ADMINISTRATOR), 'controllers/Users');
		$this->allow(array('model'=>'Group','foreign_key'=>USER_GROUP_USER), 'controllers/Users/Users/profile');
		$this->allow(array('model'=>'Group','foreign_key'=>USER_GROUP_USER), 'controllers/Users/Users/change_password');
		$this->allow(array('model'=>'Group','foreign_key'=>USER_GROUP_USER), 'controllers/Users/Profiles/my');
	}
	
	function allow($item, $path) {
		if($this->Acl->allow($item, $path)) {
			$this->out('Allowed '.$item['model'].' '.$item['foreign_key'].' to '.$path."\n");
		} else {
			$this->out('ERROR: Allowing '.$item['model'].' '.$item['foreign_key'].' to '.$path."\n");
		}
	}
}
?>