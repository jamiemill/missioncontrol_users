<div class="center_box">
	<h2><?php __('User Registration') ?></h2>

	<?php echo $form->create('User', array('action'=>'register')) ?>

		<p><?php __('Please enter your details to request a user account.') ?></p>

		<?php echo $form->input('first_name') ?>
		<?php echo $form->input('last_name') ?>
		<?php echo $form->input('email') ?>
		<?php echo $form->input('password',array('value'=>'')) ?><br />
		<?php echo $form->input('password_confirm',array('type'=>'password','value'=>'')) ?>

		<?php echo $form->submit(__('Register',true)) ?>
	
	<?php echo $form->end() ?>
</div>