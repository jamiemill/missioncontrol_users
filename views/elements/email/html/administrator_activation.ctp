<h3><?php echo sprintf(__('New %s Account',true), Configure::read('Site.title')) ?></h3>

<p>
	<span style="color:#999999">Name:</span> <?php echo $data['User']['first_name'].' '.$data['User']['last_name'] ?><br />
	<span style="color:#999999">Email:</span> <?php echo $data['User']['email'] ?><br />
</p>
<p><?php __('You can review and activate or delete the user, here:') ?></p>
<p><?php echo $html->link($html->url(array('admin'=>true,'plugin'=>'users','controller'=>'users','action'=>'view',$data['User']['id']),true))?></p>


