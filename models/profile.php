<?php

/**
* This is a placeholder model that may be overridden differently in each application and serves
* as a link between a User and any other models they may need to be associated to for a particular application.
* 
*/

class Profile extends UsersAppModel {
	
	var $belongsTo = array('Users.User');
	
	/**
	* Define your additional associations like this in the overridden version of this file.
	*/
	
	var $hasOne = array();
	var $hasMany = array();
	var $hasAndBelongsToMany = array();
	
}
?>
