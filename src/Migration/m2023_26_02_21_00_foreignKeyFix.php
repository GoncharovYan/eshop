<?php

namespace Migration;

class m2023_26_02_21_00_foreignKeyFix
{
	public static function up($connection): void
	{
		mysqli_query($connection,
			"ALTER TABLE image ADD CONSTRAINT FK_IMAGE_ITEM FOREIGN KEY (ITEM_ID) REFERENCES item(ID) ON DELETE SET NULL ON UPDATE SET NULL;");

		mysqli_query($connection,"ALTER TABLE item DROP COLUMN COUNT;");
	}
}