<?php echo sprintf(__('New %s Account',true), Configure::read('Site.title')) ?>

Name: <?php echo $data['User']['first_name'].' '.$data['User']['last_name'] ?>

Email: <?php echo $data['User']['email'] ?>

<?php __('You can review and activate or delete the user, here:') ?>

<?php echo $html->link($html->url(array('admin'=>true,'plugin'=>'users','controller'=>'users','action'=>'view',$data['User']['id']),true))?>
