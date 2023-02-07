<?php

namespace Controller;

use Models\Image;
use Models\Item;
use Models\Tag;
use Services\PageServices;

class CatalogController extends BaseController
{
    public function catalogPage(int $curPage = null)
    {
        if($curPage === null)
        {
            $curPage = 1;
        }
        //данные для тестевой пагинации
        $maxPage = 10;
        $paginator = PageServices::generatePagination($curPage,$maxPage);

        $productList = Item::findAll();
		$tagList = Tag::findAll();

		$imageList = Image::executeQuery(
			"SELECT PATH, ITEM_ID FROM image
			INNER JOIN item_image ON image.ID = item_image.IMAGE_ID
			INNER JOIN item ON item_image.ITEM_ID = item.ID
			WHERE image.IS_MAIN = true"
		);
		$imagePathList = [];
		foreach ($imageList as $image)
		{
			$imagePathList[(int)$image['ITEM_ID']-1] = $image['PATH'];
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


