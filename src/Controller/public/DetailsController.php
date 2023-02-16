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
				'content' => $this->render('public/pageNotFoundView.php', []),
			]);
		}
		else
		{
			$tag = new Tag();
			$tags = $tag->items()->find([
											'conditions' => "ITEM_ID = $id"
										]);

			// $imagePath = Image::executeQuery(
			//     "SELECT PATH, ITEM_ID
			//             FROM image
			//             INNER JOIN item_image ON image.ID = item_image.IMAGE_ID
			//             WHERE ITEM_ID = '$id'
			//             ORDER BY IS_MAIN desc"
			// );

			$imagePath = [
				"/resources/public/itemImages/iphone12promax.jpeg",
				"/resources/public/itemImages/iphone12promaxwhite.jpeg",
				"/resources/public/itemImages/CanonEOSR6.jpg",
				"/resources/public/itemImages/macbookairm2.jpg"
			];

			// if(!$imagePath)
			// {
			//     $imagePath = Image::executeQuery(
			//         "SELECT PATH, item.ID FROM image
			// 	INNER JOIN item_image ON image.ID = item_image.IMAGE_ID
			// 	INNER JOIN item ON item_image.ITEM_ID = item.ID
			//     WHERE item.ID = '$id' AND image.IS_MAIN = 1
			//     "
			//     );
			// }

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