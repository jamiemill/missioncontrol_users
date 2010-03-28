<?php echo sprintf(__('Welcome to %s',true), Configure::read('Site.title')) ?>
========================

<?php __('To activate your account, please click the following link, or copy and paste it into your browser.') ?>

<<?php echo $html->link($html->url(array('controller'=>'users','action'=>'activate_with_ticket','admin'=>false,$data['ticket']),true))?>>

<?php if(!empty($password)) : ?>
	
<?php __('Your login details are:') ?>

	<?php __('Email')?>: <?php echo $data['User']['email'] ?>

	<?php __('Password')?>: <?php echo $password ?>

<?php __('For security it is recommended that you change your password as soon as you log in.') ?>
	
<?php endif ?>

<?php __('After this, you can log into your account at:') ?> <<?php echo $html->link($html->url('/',true)) ?>>
