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

		$tag = new Tag();
		$tags = $tag->items()->find([
			'conditions' => "ITEM_ID = $id"
		]);

        $imagePath = Image::executeQuery(
            "SELECT PATH, item.ID FROM image
			INNER JOIN item_image ON image.ID = item_image.IMAGE_ID
			INNER JOIN item ON item_image.ITEM_ID = item.ID
            WHERE item.ID = '$id' AND image.IS_MAIN = 0"
        );

        if(!$imagePath)
        {
            $imagePath = Image::executeQuery(
                "SELECT PATH, item.ID FROM image
			INNER JOIN item_image ON image.ID = item_image.IMAGE_ID
			INNER JOIN item ON item_image.ITEM_ID = item.ID
            WHERE item.ID = '$id' AND image.IS_MAIN = 1"
            );
        }



        echo $this->render('layoutView.php', [
            'content' => $this->render('public/detailsPageView.php', [
                'imagePath' => $imagePath[0]->path,
                'product' => $product,
                'tags' => $tags,
            ]),
        ]);
    }
}