<?php

namespace Services;

use Models\Image;
use Models\Item;

class CatalogServices
{
	public static function getCatalogProducts(string $tag, int $curPage, string $search = '')
	{
		$itemsPerPage = ConfigurationServices::option('CATALOG_ITEM_LIMIT');
		$id = ($curPage - 1) * $itemsPerPage;
		$item = new Item();
		if ($tag !== 'all')
		{
			$condition = "ALIAS = '$tag' AND IS_ACTIVE = 1";
			if ($search !== '')
			{
				$condition .= " AND ITEM_NAME like '%$search%' ";
			}
			$productList = $item->tags()->find([
				'conditions' => $condition,
				'order' => "SORT_ORDER",
				'limit' => "$id, $itemsPerPage",
			]);
		}
		else
		{
            $condition = "IS_ACTIVE = 1";
            $productList = $item->find([
                'conditions' => $condition,
                'order' => "SORT_ORDER",
                'limit' => "$id, $itemsPerPage",
            ]);
			foreach ($productList as &$product)
			{
				$product = (array)$product;
			}
		}

		if (!$productList)
		{
			return [];
		}
		else
		{
			$itemIdArray = [];
			for ($i = 0; $i < count($productList); $i++)
			{
				$itemIdArray[] = $productList[$i]['main_image_id'];
			}
			$imageList = Image::find(['conditions' => "ID IN (" . implode(',', $itemIdArray) . ")"]);
			$imagePathList = [];
			foreach ($imageList as $image)
			{
				$imagePathList[$image->item_id] = $image->path;
			}

			for ($i = 0; $i < count($productList); $i++)
			{
				$productList[$i] += ['imagePath' => $imagePathList[$productList[$i]['id']]];
			}
		}
		return $productList;
	}

	public static function getMaxPage(string $tag, string $search = '')
	{
		$itemsPerPage = ConfigurationServices::option('CATALOG_ITEM_LIMIT');
		$item = new Item();
		if ($tag !== 'all')
		{
			$condition = "ALIAS = '$tag'";
			if ($search !== '')
			{
				$condition .= " AND ITEM_NAME like '%$search%' AND IS_ACTIVE = 1";
			}

			$fullProductList = $item->tags()->find([
				'conditions' => $condition,
			]);
		}
		else
		{
			if ($search !== '')
			{
				$fullProductList = $item->find([
					'conditions' => "ITEM_NAME like '%$search%' AND IS_ACTIVE = 1",
				]);
			}
			else
			{
                $fullProductList = $item->find([
                    'conditions' => "IS_ACTIVE = 1",
                ]);
			}
		}
		return ceil(count($fullProductList) / $itemsPerPage);
	}
}