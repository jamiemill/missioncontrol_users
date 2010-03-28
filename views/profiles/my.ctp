<?php 
$html->addCrumb('My Profile');
?>
<?php echo $this->element('crumb_heading', array('plugin'=>'core'))?>

<div class="main">
	<div class="box">
		<div class="box_head">
			<h2><?php __('My profile') ?></h2>
		</div>
		<div class="box_content">
			<?php echo $form->create('Profile',array('action'=>'my')) ?>
			
			<fieldset>
				
				<legend><?php __('Login details') ?></legend>
			
				<?php echo $form->input('User.id'); ?>
				<?php echo $form->input('User.first_name')?>
				<?php echo $form->input('User.last_name')?>
			    <?php echo $form->input('User.email',array('after'=>' '.__('(used to log in)',true))) ?> 
		
				<div class="input password">
					<label><?php __('Password') ?></label>
					<?php echo $html->link('change password...', array('plugin'=>'users', 'controller' => 'users', 'action' => 'change_password')); ?>
				</div>
				
			</fieldset>
			
			<fieldset>
				
				<legend><?php __('Profile Details') ?></legend>
			
				<?php echo $form->hidden('Profile.id'); ?>
			
				<?php
				// other fields here
				?>
				
			</fieldset>
			
			<?php echo $form->end(__('save',true)) ?> 
		</div>
	</div>
</div>
