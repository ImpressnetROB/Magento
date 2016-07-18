<?php

	$this->startSetup();

	$this->run("
	CREATE TABLE {$this->getTable('checkbox/event')}(
		'event_id' INTEGER AUTO_INCREMENT PRIMARY KEY,
		'name' VARCHAR(255),
		'start' DATETIME,
		'end' DATETIME,
		'created_at' DATETIME,
		'modified_at' DATETIME
	);
	");

	$this->endSetup();
?>
