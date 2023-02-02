<?php

namespace Controller;

use Models\Item;
use Services\PageServices;

class CatalogController extends BaseController
{
    public function catalogPage()
    {
        //данные для тестевой пагинации
        $maxPage = 10;
        $curPage = 7;
        $paginator = PageServices::generatePagination($curPage,$maxPage);

        $productList = Item::findAll();

        echo $this->render('layoutView.php', [
            'content' => $this->render('public/catalogView.php', [
                'productList' => $productList,
                'paginator' => $paginator,
            ]),
        ]);
    }
}


