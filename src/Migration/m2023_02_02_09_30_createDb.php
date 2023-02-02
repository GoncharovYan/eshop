<?php

namespace Migration;

class m2023_02_02_09_30_createDb
{
	public static function up($connection): void
	{
		mysqli_query($connection,
		'CREATE TABLE item
				(
					ID int not null auto_increment,
					NAME varchar(511) not null,
					SHORT_DESC varchar(1023),
					FULL_DESC varchar(8191),
					COUNT int default 1,
					PRICE int,
					SORT_ORDER int default 0,
					IS_ACTIVE bool default 1,
					DATE_CREATED timestamp default CURRENT_TIMESTAMP(),
					DATE_UPDATED timestamp default CURRENT_TIMESTAMP() on update CURRENT_TIMESTAMP(),
					PRIMARY KEY (ID)
				);');
		mysqli_query($connection,
		'CREATE TABLE tag
		(
			ID int not null auto_increment,
			NAME varchar(255) not null,
			PRIMARY KEY (ID)
		);');
		mysqli_query($connection,
			'CREATE TABLE item_tag
		(
			ITEM_ID int not null,
			TAG_ID int not null,
			PRIMARY KEY (ITEM_ID, TAG_ID),
			FOREIGN KEY FK_IT_ITEM (ITEM_ID)
				REFERENCES item(ID)
				ON UPDATE RESTRICT
				ON DELETE RESTRICT,
			FOREIGN KEY FK_IT_TAG (TAG_ID)
				REFERENCES tag(ID)
				ON UPDATE RESTRICT
				ON DELETE RESTRICT
		);');
		mysqli_query($connection,
			'CREATE TABLE image
		(
			ID int not null auto_increment,
			PATH varchar(511) not null,
			HEIGHT int not null,
			WIDTH int not null,
			IS_MAIN bool default 0,
			PRIMARY KEY (ID)
		);');
		mysqli_query($connection,
			'CREATE TABLE item_image
		(
			ITEM_ID int not null,
			IMAGE_ID int not null,
			PRIMARY KEY (ITEM_ID, IMAGE_ID),
			FOREIGN KEY FK_II_ITEM (ITEM_ID)
				REFERENCES item(ID)
				ON UPDATE RESTRICT
				ON DELETE RESTRICT,
			FOREIGN KEY FK_II_IMAGE (IMAGE_ID)
				REFERENCES image(ID)
				ON UPDATE RESTRICT
				ON DELETE RESTRICT
		);');
		mysqli_query($connection,
			'CREATE TABLE orders
		(
			ID int not null auto_increment,
			CUSTOMER_NAME varchar(255) not null,
			C_PHONE varchar(31),
			C_EMAIL varchar(127),
			COMMENT varchar(1023),
			ITEM_ID int not null,
			STATUS bool default 0,
			PRICE int not null,
			ADDRESS varchar(511) not null,
			DATE_CREATED timestamp default CURRENT_TIMESTAMP(),
			PRIMARY KEY (ID),
			FOREIGN KEY FK_ORDER_ITEM (ITEM_ID)
				REFERENCES item(ID)
				ON UPDATE RESTRICT
				ON DELETE RESTRICT
		);');
		mysqli_query($connection,
			'CREATE TABLE user
		(
			ID int not null auto_increment,
			EMAIL varchar(63),
			LOGIN varchar(63) not null,
			PASSWORD varchar(63) not null,
			ROLE int default 1,
			PRIMARY KEY (ID)
		);');
		mysqli_query($connection,
			'ALTER TABLE item add index IX_NAME (NAME);');
		mysqli_query($connection,
			'ALTER TABLE item add index IX_ACTIVE (IS_ACTIVE);');
	}

	public static function down(): void
	{
		//
	}
}