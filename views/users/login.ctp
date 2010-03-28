<div class="center_box">
	<div class="login_fields">
		<h2><?php __('Login') ?></h2>
		<?php echo $form->create('User', array('url' => array('plugin'=>'users','controller'=>'users','action'=>'login'))); ?>
			<?php echo $form->input('email'); ?>
			<?php echo $form->input('password'); ?>
			<p class="form-indent">
				<?php echo $html->link(__('Forgotten your password?',true), array('admin'=>false, 'plugin'=>'users','controller'=>'users','action' => 'forgotten_password'))?><br />
				<?php echo $html->link(__('Sign up',true).' &rsaquo;', array('admin'=>false, 'plugin'=>'users','controller'=>'users','action' => 'register'),array('escape'=>false))?>
			</p>
		<?php echo $form->end(array('label'=>__('Login',true), 'class'=>'button')); ?>
	</div>
</div>

