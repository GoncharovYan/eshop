<?php

namespace Migration;

class m2023_14_02_17_00_addOnDeleteCascade{
	public static function up($connection): void
	{
		mysqli_query($connection,
		"ALTER TABLE item_tag DROP FOREIGN KEY item_tag_ibfk_1;"
		);
		mysqli_query($connection,
			"ALTER TABLE item_tag ADD CONSTRAINT item_tag_ibfk_1 FOREIGN KEY (ITEM_ID)
    		REFERENCES item (ID) ON UPDATE CASCADE ON DELETE CASCADE;"
		);
		mysqli_query($connection,
			"ALTER TABLE item_tag DROP FOREIGN KEY item_tag_ibfk_2;"
		);
		mysqli_query($connection,
			"ALTER TABLE item_tag ADD CONSTRAINT item_tag_ibfk_2 FOREIGN KEY (TAG_ID)
    		REFERENCES tag (ID) ON UPDATE CASCADE ON DELETE CASCADE;"
		);

		mysqli_query($connection,
			"ALTER TABLE item_image DROP FOREIGN KEY item_image_ibfk_1;"
		);

		mysqli_query($connection,
			"ALTER TABLE item_image ADD CONSTRAINT item_image_ibfk_1 FOREIGN KEY (ITEM_ID)
    REFERENCES item (ID) ON UPDATE CASCADE ON DELETE CASCADE;"
		);

		mysqli_query($connection,
			"ALTER TABLE item_image DROP FOREIGN KEY item_image_ibfk_2;"
		);

		mysqli_query($connection,
			"ALTER TABLE item_image ADD CONSTRAINT item_image_ibfk_2 FOREIGN KEY (IMAGE_ID)
    REFERENCES image (ID) ON UPDATE CASCADE ON DELETE CASCADE;"
		);

		mysqli_query($connection,
			"ALTER TABLE item_order DROP FOREIGN KEY item_order_ibfk_1;"
		);

		mysqli_query($connection,
			"ALTER TABLE item_order ADD CONSTRAINT item_order_ibfk_1 FOREIGN KEY (ITEM_ID)
    REFERENCES item (ID) ON UPDATE CASCADE ON DELETE CASCADE;"		);

		mysqli_query($connection,
			"ALTER TABLE item_order DROP FOREIGN KEY item_order_ibfk_2;"
		);

		mysqli_query($connection,
			"ALTER TABLE item_order ADD CONSTRAINT item_order_ibfk_2 FOREIGN KEY (ORDER_ID)
    REFERENCES orders (ID) ON UPDATE CASCADE ON DELETE CASCADE;"
		);
	}
}