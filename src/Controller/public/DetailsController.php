<?php

namespace Controller\public;

use Controller\BaseController;
use Models\Image;
use Models\Item;
use Models\Tag;

class DetailsController extends BaseController
{
    public function detailsPage(int $id)
    {
		$product = Item::findById($id);

		if(!$product){
			echo $this->render('layoutView.php', [
				'content' => $this->render('objects/pageNotFoundView.php', []),
			]);
		}
		else
		{
			$tag = new Tag();
			$tags = $tag->items()->find([
			    'conditions' => "ITEM_ID = $id"
            ]);

            $imagePath = Image::find([
                'conditions' => "ITEM_ID = $id",
                'limit' => 5,
            ]);

			echo $this->render('layoutView.php', [
				'content' => $this->render('public/detailsPageView.php', [
					'imagePath' => $imagePath,
					'product' => $product,
					'tags' => $tags,
				])
			]);
		}
    }
}