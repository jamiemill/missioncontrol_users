<p><?php echo sprintf(__('You have requested to reset your %s password.',true), Configure::read('Site.title')) ?></p>
<p><?php __('Please click the link below, or copy and paste it into your browser.') ?></p>
<p><?php echo $html->link($html->url(array('controller'=>'users','action'=>'reset_password','admin'=>false,$data['ticket']),true))?></p>