<?php

namespace Controller;

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


        echo $this->render('layoutView.php', [
            'content' => $this->render('public/catalogView.php', [
                'productList' => $productList,
                'paginator' => $paginator,
				'tagList' => $tagList,
            ]),
        ]);
    }
}


