<?php
    //User settings edit list. Controls the ability for a user to edit his own account.
    $config['usel'] = array(
    'email' => array('public' => false,'user' => false,'admin'=>true,'superadmin'=>true),
    'fname' => array('public' => false,'user' => true,'admin'=>true,'superadmin'=>true),
    'lname' => array('public' => false,'user' => true,'admin'=>true,'superadmin'=>true),
);
?>