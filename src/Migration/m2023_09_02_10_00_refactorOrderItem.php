<?php

namespace Migration;

class m2023_09_02_10_00_refactorOrderItem
{
	public static function up($connection): void
	{
		mysqli_query($connection,
		"ALTER TABLE orders DROP FOREIGN KEY orders_ibfk_1;"
		);
		mysqli_query($connection,
		"ALTER TABLE orders DROP ITEM_ID;"
		);
		mysqli_query($connection,
			"CREATE TABLE item_order
			(
				ITEM_ID int not null,
				ORDER_ID int not null,
				COUNT int default 1,
				PRIMARY KEY (ITEM_ID, ORDER_ID),
				FOREIGN KEY FK_II_ITEM (ITEM_ID)
					REFERENCES item(ID)
					ON UPDATE RESTRICT
					ON DELETE RESTRICT,
				FOREIGN KEY FK_II_ORDER (ORDER_ID)
					REFERENCES orders(ID)
					ON UPDATE RESTRICT
					ON DELETE RESTRICT
			)"
		);
	}
}