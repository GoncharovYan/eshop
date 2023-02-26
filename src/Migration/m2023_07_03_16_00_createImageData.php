<?php

namespace Migration;

class m2023_07_03_16_00_createImageData
{
	public static function up($connection): void
	{
		mysqli_query($connection,
			"INSERT INTO image (ID, PATH, HEIGHT, WIDTH, IS_MAIN)
				VALUES (1, '/resources/itemImages/AmazonEchoDot(4thGen).jpg', 480, 434, 1),
					   (2, '/resources/itemImages/CanonEOSR6.jpg', 800, 1200, 1),
					   (3, '/resources/itemImages/iphone12promax.jpeg', 800, 800, 1),
					   (4, '/resources/itemImages/iphone12promaxwhite.jpeg', 800, 800, 0),
					   (5, '/resources/itemImages/macbookairm2.jpg', 800, 800, 1),
					   (6, '/resources/itemImages/NestLearningThermostat.jpg', 872, 864, 1),
					   (7, '/resources/itemImages/samsunggalaxy21ultra.jpg', 500, 467, 1),
					   (8, '/resources/itemImages/SonyWH-1000XM4.jpg', 485, 750, 1);");
		mysqli_query($connection,
			'INSERT INTO item_image(ITEM_ID, IMAGE_ID)
				VALUES (5, 8),
					   (2, 7),
					   (6, 6),
					   (3, 5),
					   (1, 4),
					   (1, 3),
					   (4, 2),
					   (7, 1);');
	}
}
