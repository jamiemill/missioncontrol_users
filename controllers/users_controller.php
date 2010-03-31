<?php

class UsersController extends UsersAppController {

	var $components = array('Core.Tickets');

	var $adminPagePath = array(8); // array representing the path through to the adminPage that represents this controller. can be overridden in individual methods. TODO: maybe use a slug instead so that it can find itself - IDs not very friendly

	function beforeFilter() {
		$this->Auth->allow('login','admin_login','logout','forgotten_password', 'reset_password','admin_forgotten_password', 'admin_reset_password', 'register','activate_with_ticket');
		$this->set('pagePath', $this->adminPagePath);
		parent::beforeFilter();
	}

	function login() {
		if(isset($this->params['admin'])) {
			$this->layout = 'admin_plain';
		} else {
			$this->layout = 'plain';
		}
		if(!empty($this->data)) {
			if($this->Auth->user()) {
				$this->User->id = $this->Auth->user('id');
				$profile = $this->User->Profile->findByUserId($this->User->id);
				$this->Session->write('Auth.Profile',$profile['Profile']);
				$loginData = array();
				$loginData['User']['modified'] = $this->Auth->user('modified'); 
				$loginData['User']['last_login'] = date("Y-m-d H:i:s");
				$this->User->save($loginData);
				$fallbackRedirect = Configure::read('User.Login.fallbackRedirect');
				if(!$fallbackRedirect) $fallbackRedirect = '/';
				$this->redirect($this->Auth->redirect($fallbackRedirect));
			}			
		}
	}

	function admin_login() {
		$this->login();
	}

	function logout() {
		$this->Session->delete('Auth');
		$this->redirect($this->Auth->logout());
	}

	function admin_index() {
		$this->set('data',$this->paginate());
	}

	function admin_change_password($id) {
		if (empty($this->data)) {	
			$this->User->id = $id;
			$this->data = $this->User->read(); 	
		} else if ($this->User->save($this->data)) {
			$this->_smartFlash(true);
		}
		$this->set('data',$this->User->findById($this->User->id));
	}

	function admin_delete($id) {
		$this->User->delete($id);
		$this->_smartFlash(sprintf(__('%s deleted.',true),__('User',true)), '/admin/users');
	}

	function forgotten_password() {
		if(isset($this->params['admin'])) {
			$this->layout = 'admin_plain';
		} else {
			$this->layout = 'plain';
		}
		$showForm = true;

		if (!empty($this->data)) {

			$theUser = $this->User->findByEmail($this->data['User']['email']); 

			if(is_array($theUser) && is_array($theUser['User'])) { 
				$ticket = $this->Tickets->set($theUser['User']['email']); 

				$result = $this->Message->sendPasswordResetEmail(array(
					'to'=>$theUser['User']['first_name'].' '.$theUser['User']['last_name'].' <'.$theUser['User']['email'].'>',
					'ticket'=>$ticket
				));

				if($result) { 
					$showForm = false;
					$this->set('message', __('A password recovery email was sent. Please check your inbox.',true)); 
				} else {
					$this->set('message', __('Server error, please try again later.',true)); 
				} 
			} else {
				$this->set('message', __('No user found with that email address.',true)); 
			}
		} 
		$this->set('showForm',$showForm); 
	}
	
	function admin_forgotten_password() {
		$this->layout = 'admin_plain';
		$this->forgotten_password();
	}

/**
 * Uses the ticket to reset the password for the correct user. 
 * This needs heavy refactoring. I think the logic is a bit mixed up, especially concerning error handling and exit points.
 * TODO: decide whether/how to persist admin vs non-admin layouts through this process. at the moment we use the admin layout as it's the only one
 * that's always guaranteed to exist because of this plugin.
 * @param  string  $hash
 */		
	function reset_password($hash = null) { 
		$this->layout = 'admin_plain';

		$showForm = true;

		if(!$hash) {
			$this->set('message', __('No ticket provided.',true)); 
		}
		elseif ( $email = $this->Tickets->get($hash) ) { 

			$authUser = $this->User->findByEmail($email); 
			if (!empty($authUser)) { 

				if (!empty($this->data)) { 

					// for handling a submitted password change /////////////
					if($authUser['User']['id'] != $this->data['User']['id']) {
						$this->_smartFlash(__("Hey! That's not your account!",true),'/');
						return;
					}
					else {
						$theUser = $this->User->findById($this->data['User']['id']); 
						//whitelist only the password field - no sneaky group or active state changes here please
						if ($this->User->save($this->data,true,array('password','password_confirm'))) { 
							$this->Tickets->delete($hash); 
							$this->Session->setFlash(sprintf(__('%s updated.',true),__('Password',true)));
							$this->redirect(array('plugin'=>'users','controller' => 'users', 'action' => 'login'));
							return true;
						}
						else { 
							$this->set('message', sprintf(__('%s could not be saved',true),__('Password',true))); 
						} 
						// to stop missing var errors
						$this->set('hash',$hash);
					}
				} 
				else {
					// for rendering the initial form //////////////
					$this->set('hash',$hash); 
					unset($authUser['User']['password']); 
					$this->data = $authUser; 
				}
			} 
			else {
				$this->set('message', sprintf(__('%s not found.',true),__('User',true))); 
				$showForm = false;
			}
		} 
		else {
			$this->set('message', __('Your ticket has expired, please request another.',true)); 
			$showForm = false;
		}
		// to stop missing var errors
		$this->set('hash',$hash); 
		$this->set('showForm',$showForm); 
	}

	function admin_reset_password() {
		$this->layout = 'admin_plain';
		$this->reset_password();
	}


	function register() {
		
		$this->layout = 'plain';
		
		if(!empty($this->data)) {
			
			$this->Auth->logout();
			
			$this->data['User']['group_id'] = USER_GROUP_USER;
			if(Configure::read('User.Register.activation') == USER_REGISTER_ACTIVATION_IMMEDIATE) {
				$this->data['User']['activated'] =  true;
			} else {
				$this->data['User']['activated'] =  false;
			}
			
			$fieldList = array('first_name','last_name','email','user_id','password','password_confirm');
			if(Configure::read('User.profileSaveWhitelist')) {
				$fieldList = Configure::read('User.profileSaveWhitelist');
			}
			$fieldList[] = 'activated';
			$fieldList[] = 'group_id';
			if($this->User->saveAll($this->data, array('fieldList'=>$fieldList,'validate'=>'first'))) {
				
				$this->__finaliseRegistrationAndSetFlash($this->User->findById($this->User->id));
				
				if(!$redirect = Configure::read('User.Register.redirect')) {
					$redirect = '/';
				}
				$this->redirect($redirect);
			} else {
				$this->_smartFlash(false);
			}
		}
		$this->_findLists(array('User','Profile'));
	}
	
	function __finaliseRegistrationAndSetFlash($data) {
		if(Configure::read('User.Register.activation') == USER_REGISTER_ACTIVATION_IMMEDIATE) {
			$this->Session->setFlash(__('You may now log in.',true));
		} elseif(Configure::read('User.Register.activation') == USER_REGISTER_ACTIVATION_SELF_ACTIVATE) {
			$this->Session->setFlash(__('Please check your inbox for an activation email.',true));
			$data['ticket'] = $this->Tickets->set($data['User']['id']);
			$result = $this->Message->sendActivationEmail($data);
			if($result) {
				$this->User->id = $data['User']['id'];
				$this->User->saveField('activation_sent',true);
			}
		} elseif(Configure::read('User.Register.activation') == USER_REGISTER_ACTIVATION_ADMIN_NOTIFY) {
			$result = $this->Message->sendAdministratorActivationEmail($data);
			$this->Session->setFlash(__('Your account is pending approval, you will be notified by email when access has been granted.',true));
		}
	}
	
	function change_password() {
		if (empty($this->data)) {	
			$this->User->id = $this->Auth->user('id');
			$this->data = $this->User->read(); 	
		} else {
			$this->data['User']['id'] = $this->Auth->user('id');
			if ($this->User->save($this->data, true, array('password','password_confirm'))) {
				$this->Session->setFlash('Password changed.');
				$this->redirect(array('controller'=>'profiles','action'=>'my'));
				return;
			}
		}
		$this->set('data',$this->User->findById($this->User->id));
	}
	
	function admin_activate($id) {
		if($this->__activateUser($id)) {
			$this->Session->setFlash('User activated.');
		} else {
			$this->Session->setFlash('Could not activate user.');
		}
		$this->redirect(array('controller' => 'users', 'action' => 'view', $id));
	}
	
	function admin_deactivate($id) {
		if($this->__deactivateUser($id)) {
			$this->Session->setFlash('User deactivated.');
		} else {
			$this->Session->setFlash('Could not deactivate user.');
		}
		$this->redirect(array('controller' => 'users', 'action' => 'view', $id));
	}
	
	function admin_send_activation($id) {
		$data = $this->User->findById($id);
		if(empty($data)) {
			$this->Session->setFlash('User not found.');
		} else {
			$ticket = $this->Tickets->set($id);
			$data['ticket'] = $ticket;
			if($this->Message->sendActivationEmail($data)) {
				$this->User->id = $id;
				$this->User->saveField('activation_sent',true);
				$this->Session->setFlash('Activation email sent.');
			} else {
				$this->Session->setFlash('Could not send activation email.');
			}
			
		}
		$this->redirect(array('controller' => 'users', 'action' => 'view', $id));
	}
	
	function __activateUser($id) {
		$this->User->id = $id;
		return $this->User->saveField('activated',true);
	}
	function __deactivateUser($id) {
		$this->User->id = $id;
		return $this->User->saveField('activated',false);
	}
	
	
	function activate_with_ticket($hash = null) {
		
		$this->layout = 'plain';
		
		if(!$hash) {
			$this->_smartFlash('No ticket provided.','flash_sess_error',array('controller'=>'users','action'=>'register'));
		}
		elseif ( $userId = $this->Tickets->get($hash) ) { 
			$user = $this->User->findById($userId); 
			if (!empty($user)) { 
				$this->User->id = $userId;
				if($this->User->saveField('activated',true)) {
					$this->_smartFlash('Congratulations! you may now log in.',array('controller'=>'users','action'=>'login'));
				} else {
					$this->_smartFlash('Could not activate user.',array('controller'=>'users','action'=>'login'));
				}
			} 
			else {
				$this->_smartFlash('User not found.',array('controller'=>'users','action'=>'register'));
			}
		} 
		else {
			$this->_smartFlash('Your ticket has expired, please try again.',array('controller'=>'users','action'=>'register'));
		}
	}
}

?>