<?php 
//User edit list. Controls the ability to edit user accounts by rank.
$config['uel'] = array(
    'user' => array('public' => false,'user' => false,'admin'=>true,'superadmin'=>true),
    'admin' => array('public' => false,'user' => false,'admin'=>false,'superadmin'=>true),
    'superadmin' => array('public' => false,'user' => false,'admin'=>false,'superadmin'=>true),
);
?>