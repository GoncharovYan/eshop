<?php

namespace Controller;

use Models\Item;

class DetailsController extends BaseController
{
    public function detailsPage(int $id)
    {
        $product = Item::findById($id);

        //@todo Вывод тегов
        //$productTags

        echo $this->render('layoutView.php', [
            'content' => $this->render('public/detailsPageView.php', [
                'product' => $product,
            ]),
        ]);
    }
}