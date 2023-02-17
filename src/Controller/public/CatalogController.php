<?php

namespace Controller\public;

use Controller\BaseController;
use Core\Web\Json;
use JetBrains\PhpStorm\NoReturn;
use Models\Image;
use Models\Item;
use Models\Tag;
use Services\CatalogServices;
use Services\ConfigurationServices;
use Services\PageServices;

class CatalogController extends BaseController
{
    public function catalogPage(string $tag = null, int $curPage = null)
    {
        if($curPage === null)
        {
            if($tag === null || is_numeric($tag))
            {
                $tag = 'all';
            }
            header("Location: /catalog/{$tag}/1/");
        }
        else {
            $tagList = Tag::find(['limit' => '10']);
            $search = $_GET['search'] ?? '';

            $productList = CatalogServices::getCatalogProducts($tag, $curPage, $search);
            $maxPage = CatalogServices::getMaxPage($tag, $search);
            $paginator = [
                'curPage' => $curPage,
                'maxPage' => $maxPage,
            ];

            echo $this->render('layoutView.php', [
                'content' => $this->render('public/catalogView.php', [
                    'productList' => $productList,
                    'paginator' => $paginator,
                    'tagList' => $tagList,
                    'search' => $search,
                ]),
            ]);
        }
	}

    public function changePage(string $tag, int $curPage)
    {
        $search = $_GET['search'] ?? '';
        $productList = CatalogServices::getCatalogProducts($tag, $curPage, $search);
        $catalogList = [];
        foreach ($productList as $product){
            $catalogList[] = [
                'id' => $product['id'],
                'title' => $product['item_name'],
                'shortDesc' => $product['short_desc'],
                'price' => $product['price'],
                'imagePath' => $product['imagePath'],
            ];
        }
        echo Json::encode([
            $catalogList,
        ]);
    }
}


