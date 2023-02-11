<?php

namespace Controller;

use Models\Image;
use Models\Item;
use Models\Tag;

class DetailsController extends BaseController
{
    public function detailsPage(int $id)
    {
        $product = Item::findById($id);

		$tag = new Tag();
		$tags = $tag->items()->find([
			'conditions' => "ITEM_ID = $id"
		]);

        echo $this->render('layoutView.php', [
            'content' => $this->render('public/detailsPageView.php', [
                'product' => $product,
                'tags' => $tags,
            ]),
        ]);
    }
}