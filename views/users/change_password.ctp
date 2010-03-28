<?php 
$html->addCrumb(__('My Profile',true), array('plugin'=>'users','controller'=>'users','action'=>'profile'));
$html->addCrumb(__('change password',true));
?>
<?php echo $this->element('crumb_heading', array('plugin'=>'core'))?>

<div class="main">
	<div class="box">
		<div class="box_head">
			<h2><?php echo sprintf( __('Edit %s',true),__('user',true)) ?></h2>
		</div>
		<div class="box_content">
			<?php echo $form->create('User', array('action'=>'change_password')) ?>
			<p><?php echo sprintf(__('Enter new password for %s',true), $this->data['User']['email']) ?>:</p>

			<?php echo $form->hidden('id'); ?>

			<?php // email included because Auth won't auto-hash password unless it is present in the data ?>
			<?php echo $form->hidden('email'); ?>
			<?php echo $form->input('password', array('type' => 'password', 'value' => ''))?>
			<?php echo $form->input('password_confirm', array('type' => 'password', 'value' => ''))?>

			<?php echo $form->submit(__('Save',true)) ?>

			<?php echo $form->end()?>
		</div>
	</div>
</div>
