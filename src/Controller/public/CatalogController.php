<?php

namespace Controller\public;

use Controller\BaseController;
use Models\Image;
use Cache\FileCache;
use Models\Item;
use Models\Tag;
use Models\User;
use Services\ConfigurationServices;
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

        $itemsPerPage = ConfigurationServices::option('CATALOG_ITEM_LIMIT');
        $id = ($curPage-1)*$itemsPerPage;

		if($tag !== 'all')
		{
			$productList = Item::executeQuery("select * from item 
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
            $productList = Item::findAll();
            $maxPage = ceil(count($productList)/$itemsPerPage);

            if ($search !== '')
            {
                $productList = Item::executeQuery("	select * from item
															where ITEM_NAME like '%$search%'
															limit $id,$itemsPerPage");
            }
            else {
                $productList = Item::find([
                    'limit' => "$id, $itemsPerPage"]);
            }
		}

		if(!$productList)
		{
            echo $this->render('layoutView.php', [
                'content' => $this->render('public/pageNotFoundView.php', []),
                ]);

        }
		else
        {
            $paginator = PageServices::generatePagination($curPage,$maxPage);

            $tagList = $cache->remember('tagList', 30, function(){
                $provider = new Tag();
                return $provider->find(['limit' => '10']);
            });

            $itemIdArray = [];
            foreach ($productList as $product)
            {
                $itemIdArray[] = $product->id;
            }

            $imageList = Image::executeQuery(
                "SELECT image.PATH, ID FROM image
            WHERE ITEM_ID IN (" . implode(',', $itemIdArray) . ")
            "
            );
			// $imageList = Image::find(['conditions' => "ITEM_ID IN (" . implode(',', $itemIdArray) . ")"]);

            $imagePathList = [];

            foreach ($imageList as $image) {
                $imagePathList[] = $image->path;
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
}


