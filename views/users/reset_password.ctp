<div class="center_box">

	<h2><?php __('Reset Password') ?></h2>

	<div class="login_fields">
		
		<?php if($showForm) : ?>
		
			<p><?php __('Please enter a new password.') ?></p>
		
			<?php echo $form->create('User',array('action'=>'reset_password/'.$hash)) ?>

				<?php echo $form->input('email',array('type'=>'hidden')) ?>
				<?php echo $form->input('password',array('type'=>'password','value'=>'')) ?>
				<?php echo $form->input('password_confirm',array('type'=>'password','value'=>'')) ?>
				<?php echo $form->input('id') ?>

			<?php echo $form->end(__('Reset',true)) ?>
			
		<?php endif ?>

		<?php if(isset($message)) : ?>
			<p><?php echo $message ?></p>
		<?php endif ?>

	</div>
</div>