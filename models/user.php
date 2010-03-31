<?php

class User extends UsersAppModel {
	
	var $belongsTo = array('Users.Group');
	var $hasOne = array('Profile'=>array('className'=>'Users.Profile','dependent'=>true));
	var $order = array('group_id'=>'desc','first_name'=>'asc');
	
	function loadValidation() {
		$this->validate = array(
			'first_name'=>array(
				'not empty.'=>array(
					'rule'=>'notEmpty',
					'message'=>__('Please enter a name.',true)
				)
			),
			'last_name'=>array(
				'not empty.'=>array(
					'rule'=>'notEmpty',
					'message'=>__('Please enter a name.',true)
				)
			),
			'email' => array(
				'email' => array(
					'rule' => 'email',
					'required' => true,
					'message' => __('Please enter a valid email address.',true),
				),
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => __('That email address has already been used. Please try another.',true),
				)
			),
			'password' => array(
				'requiredOnCreate'=> array(
					'rule'=>'notEmpty',
					'required'=>true,
					'on'=>'create',
					'message'=>__('Please enter a password',true)
				),
				'matches' => array(
					'rule' => array('confirmPassword'), 
					'message' => __('Passwords do not match',true)
				)
			),
			'password_confirm' => array(
				'requiredOnCreate'=> array(
					'rule'=>'notEmpty',
					'required'=>true,
					'on'=>'create',
					'message'=>__('Please enter a password',true)
				),			
				'length' => array(
					'rule' => array('minLength', 6),
					'message' => __('Please choose a password six or more characters in length.',true)
				)
			),
		);
	} 
	
	function confirmPassword($data) {
		$valid = false;
		if ($data['password'] == Security::hash(Configure::read('Security.salt') . $this->data['User']['password_confirm'])) {
			$valid = true;
		}
		return $valid;
	}
	
/**
 * Custom validation function to verify that the contents of the specified form fields is identical.
 *
 * @param mixed  $check The value to be validated.
 * @param string $field The field to check.
 * @return boolean Success
 * @access public
 */
	function isIdenticalTo($check, $field) {
		return $check[key($check)] === $this->data['User'][$field];
	}

}
?>
