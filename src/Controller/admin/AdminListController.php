<?php

namespace Controller\admin;

use Controller\BaseController;
use Models\Image;
use Models\Item;
use Models\Orders;
use Models\Tag;
use Models\User;
use Services\UserServices;

class AdminListController extends BaseController
{
	public function adminListPage(string $className)
	{
        if(!UserServices::isAdmin())
        {
            header("Location: /catalog/all/1/");
            exit;
        }

		$class = "\Models\\" . ucfirst($className);
		$class = new $class();

		$dataList = $class::findAll();

		$dataTable = [];
		$dataTableHead = array_keys(get_class_vars($class::class));
		foreach ($dataList as $product)
		{
			$newRow = get_object_vars($product);
			foreach ($newRow as $key => $data)
			{
				$newRow[$key] = $this->truncateText($data);
			}
			$dataTable[] = $newRow;
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/adminListView.php', [
				'contentTable' => $dataTable,
				'contentTableHead' => $dataTableHead,
				'contentType' => $className,
			]),
		]);
	}

	private function truncateText(string|null $text)
	{
		if ($text === null)
		{
			return $text;
		}
		$maxLength = 50;
		$cropped = mb_substr($text, 0, $maxLength, 'UTF-8');
		if ($cropped !== $text)
		{
			return "$cropped...";
		}
		return $text;
	}
}
