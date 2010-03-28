<?php

Router::connect('/admin/users', array('admin'=>true, 'plugin'=>'users', 'controller' => 'users', 'action' => 'index'));

?>