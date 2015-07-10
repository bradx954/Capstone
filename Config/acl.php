<?php

//access control list		
 $config['acl'] = array('home' 			=> 		array('public' => true, 'user' => true,		'admin'=>true,	'superadmin'=>true),
					'files' 			=> 		array('public' => false, 'user' => true,		'admin'=>true,	'superadmin'=>true),
					'users' 		=> 		array('public' => false, 'user' => false,		'admin'=>true,	'superadmin'=>true),
                    'server' 		=> 		array('public' => false, 'user' => false,		'admin'=>false,	'superadmin'=>true)
 					);

?>
