<?php

namespace Core\Database\Migration;

use Services\DatabaseServices;

/**
 * Мигратор
 */
class Migrator
{
	private static string|null $lastMigration;
	private static string $migrationPath = __DIR__ . '/../../../src/Migration/';
	private static string $migrationClassPath = "Migration\\";
	private static \mysqli $connection;

	/**
	 * метод миграции
	 *
	 * смотрит последнюю миграцию,
	 * ищет и выполняет новые миграции,
	 * обновляет данные о примененных миграциях
	 *
	 * @return void
	 */
	public static function migrate(): void
	{
		self::$connection = DatabaseServices::getDbConnection();
		self::checkMigrationTable();
		self::$lastMigration = self::getLastAppliedMigration();
		$migrations = self::getNewMigrations();
		foreach ($migrations as $migration)
		{
			self::applyMigration($migration);
			self::updateLastAppliedMigration($migration);
		}
	}

	/**
	 * проверяет таблицу migration
	 *
	 * проверят наличие таблицы migration и при отсутвии создает ее
	 *
	 * @return void
	 */
	private static function checkMigrationTable(): void
	{
		$query = "SHOW TABLES LIKE 'migration'";
		$result = mysqli_query(self::$connection, $query);
		if ($result->num_rows === 0)
		{
			$query = 'CREATE TABLE migration (
                ID INT AUTO_INCREMENT PRIMARY KEY,
                NAME VARCHAR(255) NOT NULL,
                APPLIED_AT DATETIME NOT NULL
            )';
			mysqli_query(self::$connection, $query);
		}
	}

	/**
	 * Возвращает последнюю примененную миграцию
	 *
	 * @return string|null
	 */
	private static function getLastAppliedMigration(): string|null
	{
		$query = 'SELECT `NAME` FROM `migration` ORDER BY `NAME` DESC LIMIT 1';
		$result = mysqli_query(self::$connection, $query);
		if ($result->num_rows !== 0)
		{
			$row = (array)mysqli_fetch_assoc($result);
			return $row['NAME'];
		}
		return null;
	}

	/**
	 * Возвращает новые миграции
	 *
	 * сканирует путь миграции на наличие новых миграций,
	 * возвращает массив новых миграций в виде имен файлов
	 *
	 * @return array
	 */
	private static function getNewMigrations(): array
	{
		$migrations = [];
		$files = scandir(self::$migrationPath);
		foreach ($files as $file)
		{
			if ($file === '.' || $file === '..')
			{
				continue;
			}
			if (strcmp($file, self::$lastMigration) > 0)
			{
				$migrations[] = $file;
			}
		}
		sort($migrations);
		return $migrations;
	}

	/**
	 * Применяет миграции
	 *
	 * Выполняет миграции, передавая им подключение к БД
	 *
	 * @param $migration
	 * @return void
	 */
	private static function applyMigration($migration): void
	{
		$migrationClass = self::$migrationClassPath . str_replace('.php', '', $migration);
		$mig = new $migrationClass;
		$mig::up(self::$connection);
	}

	/**
	 * Обновляет данные в таблице миграций
	 *
	 * добавляет примененную интеграцию в таблицу интеграций
	 *
	 * @param $migration
	 * @return void
	 */
	private static function updateLastAppliedMigration($migration): void
	{
		mysqli_query(self::$connection, ("INSERT INTO migration (NAME, APPLIED_AT) VALUES ('$migration', CURRENT_TIMESTAMP())"));
	}
}
