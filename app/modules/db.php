<?php
	try {
	$link = new PDO('mysql:host='.$db['host'].';dbname='.$db['name'].'', ''.$db['user'].'', ''.$db['pass'].'');
	} catch (PDOExeption $e) {
		print($e->getMessage());
		die();
	}
?>