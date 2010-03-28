<?php echo $this->element('record_navigation', array('plugin'=>'core'))?>
<?php 
$html->addCrumb('Users');
?>
<?php echo $this->element('crumb_heading', array('plugin'=>'core'))?>

<div class="clear"></div>
<div class="box">
	<div class="box_head">
		<h2>
			<?php echo sprintf( __('All %s',true),__('Users',true)) ?>
		</h2>
	</div>
	<div class="box_content">
		<?php if(!empty($data)) : ?>
		<?php echo $this->element('paging_info',array('plugin'=>'core')) ?>
		<?php echo $this->element('paging',array('plugin'=>'core')) ?>
		<table class="admin_listing">
			<tr>
				<th><?php echo $paginator->sort('Name','first_name');?></th>
				<th><?php echo $paginator->sort('email');?></th>
				<th><?php echo $paginator->sort('activation_sent');?></th>
				<th><?php echo $paginator->sort('activated');?></th>
				<th><?php echo $paginator->sort('enabled');?></th>
				<th><?php echo $paginator->sort('Group','Group.id');?></th>
				<th class="actions"><?php __('Actions');?></th>
			</tr>
			<?php foreach($data as $user) : ?>
			<tr>
				<td><?php echo $html->link($user['User']['first_name'].' '.$user['User']['last_name'],array('admin'=>true,'controller'=>'users','action'=>'view',$user['User']['id'])) ?></td>
				<td><?php echo $user['User']['email'] ?></td>
				<td><?php echo $layout->flag($user['User']['activation_sent']) ?></td>
				<td><?php echo $layout->flag($user['User']['activated']) ?></td>
				<td><?php echo $layout->flag($user['User']['enabled']) ?></td>
				<td><?php echo $user['Group']['title'] ?></td>
				<td class="actions">
					<?php echo $nav->edit(array($user['User']['id'])); ?> 
					<?php echo $nav->delete(array($user['User']['id'])); ?> 
				</td>
			</tr>
			<?php endforeach ?> 
		</table>
		<?php endif ?> 
	</div>
</div>