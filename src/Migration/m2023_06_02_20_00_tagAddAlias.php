<?php

namespace Migration;

class m2023_06_02_20_00_tagAddAlias
{
	public static function up($connection): void
	{
		mysqli_query($connection,
			'ALTER TABLE tag CHANGE COLUMN NAME TAG_NAME varchar(255);'
		);
		mysqli_query($connection,
			'ALTER TABLE item CHANGE COLUMN NAME ITEM_NAME varchar(255);');
		mysqli_query($connection,
			'ALTER TABLE tag ADD COLUMN ALIAS varchar(255) NOT NULL;');
		mysqli_query($connection,
			"INSERT INTO tag (id,ALIAS)
				VALUES (1,'phone'),(2,'laptop'),(3,'camera'),(4,'wireless'),(5,'smarthome')
				ON DUPLICATE KEY UPDATE ALIAS = VALUES(ALIAS);");
	}
}