<?php

namespace Controller;

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


        echo $this->render('layoutView.php', [
            'content' => $this->render('public/catalogView.php', [
                'productList' => $productList,
                'paginator' => $paginator,
				'tagList' => $tagList,
            ]),
        ]);
    }
}


