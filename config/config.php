<?php

Config::set('site_name','Аукцион');

Config::set('languages', array('ua','en'));

//Routes/ Route name => method prefix

Config::set('routes',array(
	'default' => '',
	'admin' => 'admin_',
	));

Config::set('default_route','default');
Config::set('default_languages','ua');
Config::set('default_controller','mainlist');
Config::set('default_action','index');
Config::set('default_num_foto','3');

Config::set('db.host','localhost');
Config::set('db.user','root');
Config::set('db.password','');
Config::set('db.db_name','mvc');

Config::set('salt','fds45re345sfjutd5');
Config::set('adsperpage',5);

	
	