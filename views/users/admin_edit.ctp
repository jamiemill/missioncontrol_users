<?php 
$html->addCrumb('Users',array('controller'=>'users','action'=>'index'));
$html->addCrumb($data['User']['first_name'].' '.$data['User']['last_name'],array('controller'=>'users','action'=>'view',$data['User']['id']));
$html->addCrumb('edit');
?>
<?php echo $this->element('crumb_heading', array('plugin'=>'core'))?>

<div class="main">
	<div class="box">
		<div class="box_head">
			<h2><?php echo sprintf( __('Edit %s',true),__('user',true)) ?></h2>
		</div>
		<div class="box_content">
			<?php echo $form->create('User') ?>
			<?php echo $form->hidden('id'); ?>
			<?php echo $form->input('first_name')?>
			<?php echo $form->input('last_name')?>
			<?php echo $form->input('email',array('after'=>' '.__('(used to log in)',true))) ?> 
			<?php echo $form->input('activated')?>
			<?php echo $form->input('enabled')?>
			<?php echo $form->input('activation_sent')?>
			<?php echo $form->input('group_id')?>
			<?php echo $form->end('save') ?> 
		</div>
	</div>
</div>
