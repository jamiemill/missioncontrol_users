<h3><?php echo sprintf(__('Welcome to %s',true), Configure::read('Site.title')) ?></h3>

<p><?php __('To activate your account, please click the following link, or copy and paste it into your browser.') ?></p>
<p><?php echo $html->link($html->url(array('controller'=>'users','action'=>'activate_with_ticket','admin'=>false,$data['ticket']),true))?></p>

<?php if(!empty($password)) : ?>
	<p><?php __('Your login details are:') ?></p>
	<ul>
		<li><?php __('Email')?>: <?php echo $data['User']['email'] ?></li>
		<li><?php __('Password')?>: <?php echo $password ?></li>
	</ul>
	<p><?php __('For security it is recommended that you change your password as soon as you log in.') ?></p>
	
<?php endif ?>

<p><?php __('After this, you can log into your account at:') ?> <?php echo $html->link($html->url('/',true)) ?></p>
