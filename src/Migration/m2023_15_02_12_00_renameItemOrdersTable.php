<?php

namespace Migration;

class m2023_15_02_12_00_renameItemOrdersTable
{
	public static function up($connection): void
	{
		mysqli_query($connection,
			"RENAME TABLE item_order TO item_orders"
		);
		mysqli_query($connection,
			"ALTER TABLE item_orders CHANGE COLUMN ORDER_ID ORDERS_ID int"
		);
		mysqli_query($connection,
			"ALTER TABLE item_orders CHANGE COLUMN COUNT ITEM_COUNT int default 1"
		);
	}
}