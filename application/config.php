<?php
return array(
    'sitename' => 'Тестовая страница php фреймворка',
    'db' => include 'config.db.php',
	'router' => array( 
		'([a-z0-9+_\-]+)/([a-z0-9+_\-]+)/([0-9]+)' => '$controller/$action/$id',
        '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)' => '$controller/$action',
        '([a-z0-9+_\-]+)/?' => '$controller',
        '([a-z0-9+_\-]+)\.html' => 'page/read/$id',
	),
);
