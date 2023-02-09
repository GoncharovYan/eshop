<?php

namespace Controller;

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

        $itemsPerPage = 3;
        $id = ($curPage-1)*$itemsPerPage;

		if($tag !== 'all'){
			$productList = Item::executeQuery("select count(*) from item 
                                                    join item_tag it on ID = it.ITEM_ID
													join tag t on t.ID = it.TAG_ID
													where t.ALIAS = '$tag'");
            $maxPage = ceil(count($productList)/$itemsPerPage);
            $productList = Item::executeQuery("select item.* from item 
                                                    join item_tag it on ID = it.ITEM_ID
													join tag t on t.ID = it.TAG_ID
													where t.ALIAS = '$tag'
													limit $id,$itemsPerPage");


		}
		else{
			$productList = Item::findAll();
            $maxPage = ceil(count($productList)/$itemsPerPage);

            $productList = Item::find([
                'limit' => "$id, $itemsPerPage",
            ]);


		}

        $paginator = PageServices::generatePagination($curPage,$maxPage);

        $tagList = $cache->remember('tagList', 3600, function(){
            $provider = new Tag();
            return $provider->find(['limit' => '10']);
        });

        echo $this->render('layoutView.php', [
            'content' => $this->render('public/catalogView.php', [
                'productList' => $productList,
                'paginator' => $paginator,
				'tagList' => $tagList,
            ]),
        ]);
    }
}


