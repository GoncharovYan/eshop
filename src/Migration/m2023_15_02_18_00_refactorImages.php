<?php

namespace Migration;

class m2023_15_02_18_00_refactorImages
{
	public static function up($connection): void
	{
		mysqli_query($connection,
			"UPDATE image SET ID = ID+1 ORDER BY ID DESC;"
		);
		mysqli_query($connection,
			"INSERT INTO image (ID, PATH, HEIGHT, WIDTH, IS_MAIN)
			VALUE (1, '/resources/itemImages/no_image.png', 1000, 1000, 0);"
		);
		mysqli_query($connection,
			"ALTER TABLE item ADD MAIN_IMAGE_ID int default 1;"
		);
		mysqli_query($connection,
			"UPDATE item
				INNER JOIN item_image ON item_image.ITEM_ID = item.ID
				INNER JOIN image ON item_image.IMAGE_ID = image.ID
			SET item.MAIN_IMAGE_ID = item_image.IMAGE_ID
			WHERE IS_MAIN = 1;"
		);
		mysqli_query($connection,
			"ALTER TABLE image DROP COLUMN IS_MAIN;"
		);
		mysqli_query($connection,
			"ALTER TABLE image ADD ITEM_ID int;"
		);
		mysqli_query($connection,
			"UPDATE image
				INNER JOIN item_image ON image.ID = item_image.IMAGE_ID
			SET image.ITEM_ID = item_image.ITEM_ID
			WHERE ID>1;"
		);
		mysqli_query($connection,
			"DROP TABLE item_image"
		);
	}
}