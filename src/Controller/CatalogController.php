<?php

namespace Controller;

use Models\Image;
use Cache\FileCache;
use Dto\Relation;
use Models\Item;
use Models\Tag;
use Models\User;
use Services\PageServices;

class CatalogController extends BaseController
{
    public function catalogPage(string $tag, int $curPage = null)
    {
        $cache = new FileCache();
        if($curPage === null)
        {
            $curPage = 1;
        }
        $search = $_GET['search'] ?? '';

        $itemsPerPage = 3;
        $id = ($curPage-1)*$itemsPerPage;

		if($tag !== 'all')
		{
			$productList = Item::executeQuery("select count(*) from item 
                                                    join item_tag it on ID = it.ITEM_ID
													join tag t on t.ID = it.TAG_ID
													where t.ALIAS = '$tag'");
            $maxPage = ceil(count($productList)/$itemsPerPage);
            $query = "select item.* from item 
                                                    join item_tag it on ID = it.ITEM_ID
													join tag t on t.ID = it.TAG_ID
													where t.ALIAS = '$tag'";
            if ($search !== '')
            {
                $query .= " and ITEM_NAME like '%$search%'";
            }
            $productList = Item::executeQuery($query."limit $id,$itemsPerPage");
		}
		else{
            if ($search !== '')
            {
                $productList = Item::executeQuery("	select * from item
															where ITEM_NAME like '%$search%'
															limit $id,$itemsPerPage");
            }
            else {
                $productList = Item::find([
                    'limit' => "$id, $itemsPerPage",]);
            }
			$productList = Item::findAll();
            $maxPage = ceil(count($productList)/$itemsPerPage);

		}

        $paginator = PageServices::generatePagination($curPage,$maxPage);

        $tagList = $cache->remember('tagList', 3600, function(){
            $provider = new Tag();
            return $provider->find(['limit' => '10']);
        });

        $itemIdArray = [];
        foreach ($productList as $product)
        {
            $itemIdArray[] = $product->id;
        }

        $imageList = Image::executeQuery(
            "SELECT PATH, item.ID FROM image
			INNER JOIN item_image ON image.ID = item_image.IMAGE_ID
			WHERE item_image.ITEM_ID = IN (" . implode(',', $itemIdArray) . ")"
        );
        $imagePathList = [];
        foreach ($imageList as $image) {
            $imagePathList[$image->id] = $image->path;
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


