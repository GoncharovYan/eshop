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
        if($curPage === null)
        {
            $curPage = 1;
        }
        //данные для тестевой пагинации
        $maxPage = 10;
        $paginator = PageServices::generatePagination($curPage,$maxPage);

		if($tag !== 'all'){
			$productList = Item::executeQuery("select * from item 
                                                    join item_tag it on item.ID = it.ITEM_ID
													join tag t on t.ID = it.TAG_ID
													where t.ALIAS = '$tag'");
		}
		else{
			$productList = Item::findAll();
		}
		$tagList = Tag::find([
			'limit' => '10'
							 ]);

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


