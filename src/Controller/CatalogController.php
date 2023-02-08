<?php

namespace Controller;

use Models\Image;
use Models\Item;
use Models\Tag;
use Services\PageServices;

class CatalogController extends BaseController
{
	public function catalogPage(string $tag, int $curPage = null)
	{
		if ($curPage === null) {
			$curPage = 1;
		}
		//данные для тестевой пагинации
		$maxPage = 10;
		$paginator = PageServices::generatePagination($curPage, $maxPage);

		$search = $_GET['search'] ?? '';

		// Сортировка по тегам и/или названию
		if ($tag !== 'all') {
			$query = "	select item.* from item 
                    	join item_tag it on item.ID = it.ITEM_ID
						join tag t on t.ID = it.TAG_ID
						where t.ALIAS = '$tag'";
			if ($search !== '')
			{
				$query .= " and ITEM_NAME like '%$search%'";
			}
			$productList = Item::executeQuery($query);
		} else {
			if ($search !== '')
			{
				$productList = Item::executeQuery("	select * from item
															where ITEM_NAME like '%$search%'");
			} else {
				$productList = Item::findAll();
			}
		}

		$tagList = Tag::find([
			'limit' => '10'
		]);

		$imageList = Image::executeQuery(
			"SELECT PATH, item.ID FROM image
			INNER JOIN item_image ON image.ID = item_image.IMAGE_ID
			INNER JOIN item ON item_image.ITEM_ID = item.ID
			WHERE image.IS_MAIN = true"
		);
		$imagePathList = [];
		foreach ($imageList as $image) {
			$imagePathList[$image->id] = $image->path;
		}


		echo $this->render('layoutView.php', [
			'content' => $this->render('public/catalogView.php', [
				'productList' => $productList,
				'paginator' => $paginator,
				'tagList' => $tagList,
				'imagePathList' => $imagePathList,
			]),
		]);
	}
}


