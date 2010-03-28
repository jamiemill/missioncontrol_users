<?php echo $this->element('record_navigation', array('plugin'=>'core'))?>
<?php 
$html->addCrumb(__('Users',true),array('controller'=>'users','plugin'=>'users','action'=>'index'));
$html->addCrumb($data['User']['first_name'].' '.$data['User']['last_name']);
?>
<?php echo $this->element('crumb_heading', array('plugin'=>'core'))?>


<div class="record_navigation">
</div>
<div class="main">
	<div class="box">
		<div class="box_head">
			<h2><?php __('User') ?> : <?php echo $data['User']['first_name']?> <?php echo $data['User']['last_name']?></h2>
		</div>
		<div class="box_content">
			<table class="admin_listing admin_view">
				<tr><td><?php __('Name') ?></td><td><?php echo $data['User']['first_name']?> <?php echo $data['User']['last_name']?></td></tr>
				<tr><td><?php __('Email (used to log in)')?></td><td><?php echo $data['User']['email']?></td></tr>
				<tr><td><?php __('Password') ?></td><td><?php echo $html->link(__('Change password',true), array('action' => 'change_password', $data['User']['id'])) ?></td></tr>
				<tr><td><?php __('Registered') ?></td><td><?php echo $data['User']['created']?></td></tr>
				<tr>
					<td><?php __('Activation Sent') ?></td>
					<td>
						<?php echo $layout->flag($data['User']['activation_sent']) ?>
						<?php echo $html->link(__('Send self-activation email',true), array('admin'=>true, 'plugin'=>'users','controller'=>'users','action'=>'send_activation',$data['User']['id']), array(), __('Are you sure?',true)) ?>
					</td>
				</tr>
				<tr>
					<td><?php __('Activated') ?></td>
					<td>
						<?php echo $layout->flag($data['User']['activated']) ?>
					</td>
				</tr>
				<tr><td><?php __('Enabled') ?></td><td><?php echo $layout->flag($data['User']['enabled']) ?></td></tr>
				<tr><td><?php __('Group') ?></td><td><?php echo $data['Group']['title']?></td></tr>
			</table>
		</div>
	</div>
</div>

<div class="sidebar">
	
</div>