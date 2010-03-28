<div class="center_box">

	<h2><?php __('Forgotten password') ?></h2>

	<div class="login_fields">
		
		<?php if($showForm) : ?>

			<p><?php __('Please enter your email address. A reset ticket will be emailed to you.') ?></p>
		
			<?php echo $form->create('User',array('action'=>'forgotten_password')) ?>

				<?php echo $form->input('email') ?>

			<?php echo $form->end(__('Request reset ticket',true)) ?>
			
		<?php endif ?>

		<?php if(isset($message)) : ?>
			<p><?php echo $message ?></p>
		<?php endif ?>

	</div>
</div>