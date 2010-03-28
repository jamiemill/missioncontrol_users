<div class="center_box">

	<div class="login_fields">
		<h2><?php __('Login') ?></h2>
		<?php echo $form->create('User', array('action' => 'admin_login')); ?>
			<?php echo $form->input('email'); ?>
			<?php echo $form->input('password'); ?>
			<p class="form-indent"><?php echo $html->link(__('Forgotten your password?',true), array('action' => 'forgotten_password'))?></p>
		<?php echo $form->end(array('label'=>'Login', 'class'=>'button')); ?>
	</div>
	

</div>

