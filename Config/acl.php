<?php

//access control list		
 $config['acl'] = array('home' 			=> 		array('public' => true,		'bronze'=>true,	'silver'=>true,	'gold'=>true, 	'admin' => true),
					'staff' 			=> 		array('public' => false,	'bronze'=>true,	'silver'=>true,	'gold'=>false, 	'admin' => true),
					'supervisors' 		=> 		array('public' => false,	'bronze'=>false,'silver'=>true,	'gold'=>false, 	'admin' => true),
					'helpdesk' 			=> 		array('public' => false,	'bronze'=>false,'silver'=>false,'gold'=>true, 	'admin' => true),
					'admin' 			=> 		array('public' => false,	'bronze'=>false,'silver'=>false,'gold'=>false, 	'admin' => true),
					'login' 			=> 		array('public' => true,		'bronze'=>true,	'silver'=>true,	'gold'=>true, 	'admin' => true),
					'logout' 			=> 		array('public' => true,		'bronze'=>true,	'silver'=>true,	'gold'=>true, 	'admin' => true),
					'register' 			=> 		array('public' => true,		'bronze'=>true,	'silver'=>true,	'gold'=>true, 	'admin' => true) 
 					);

?>
