<?php

namespace Migration;

class m2023_15_02_20_30_fixImagePathData
{
		public static function up($connection): void
		{
			mysqli_query($connection,
				"UPDATE image SET ID = ID+1 ORDER BY ID DESC;"
			);
		}
}