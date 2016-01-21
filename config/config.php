<?php
// зададим 2 языка в парам. languages 
Config::set('languages', array('ua','en'));

//Routes/ Route name => method prefix
// основной роутер - дефолт и админ
Config::set('routes',array(
	'default' => '',
	'admin' => 'admin_',
	));
// парамерты подключения к базе
Config::set('db.host','localhost');
Config::set('db.user','root');
Config::set('db.password','');
Config::set('db.db_name','mvc');
// хеш довесок к шифру пароля
Config::set('salt','fds45re345sfjutd5');

Config::connect();

	
	