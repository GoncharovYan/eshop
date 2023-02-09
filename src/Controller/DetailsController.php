<?php

namespace Controller;

use Models\Item;
use Models\Tag;

class DetailsController extends BaseController
{
    public function detailsPage(int $id)
    {
        $product = Item::findById($id);

        $tags = Tag::find([
            'conditions' => "ID IN (
                SELECT it.TAG_ID 
                FROM item_tag it
                WHERE it.ITEM_ID = $id
            )",
        ]);

        echo $this->render('layoutView.php', [
            'content' => $this->render('public/detailsPageView.php', [
                'product' => $product,
                'tags' => $tags,
            ]),
        ]);
    }
}