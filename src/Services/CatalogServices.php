<?php

namespace Services;

use Models\Image;
use Models\Item;

class CatalogServices
{
    public static function getCatalogProducts(string $tag, int $curPage, string $search = '')
    {
        $itemsPerPage = ConfigurationServices::option('CATALOG_ITEM_LIMIT');
        $id = ($curPage-1)*$itemsPerPage;
        $item = new Item();
        if($tag !== 'all')
        {
            $condition = "ALIAS = '$tag'";
            if ($search !== '')
            {
                $condition .= " AND ITEM_NAME like '%$search%'";
            }

            $productList = $item->tags()->find([
                'conditions' =>  $condition,
                'limit' => "$id, $itemsPerPage",
            ]);
        }
        else
        {
            if ($search !== '')
            {
                $productList = $item->find([
                    'conditions' =>  "ITEM_NAME like '%$search%'",
                    'limit' => "$id, $itemsPerPage",
                ]);
            }
            else
            {
                $productList = $item->find([
                    'limit' => "$id, $itemsPerPage"]);
            }
            foreach ($productList as &$product)
            {
                $product = (array)$product;
            }
        }

        if(!$productList)
        {
            return [];
        }
        else {
            $itemIdArray = [];
            for ($i = 0; $i < count($productList); $i++)
            {
                $itemIdArray[] = $productList[$i]['main_image_id'];
            }
            $imageList = Image::find(['conditions' => "ID IN (" . implode(',', $itemIdArray) . ")"]);
            $imagePathList = [];
            foreach ($imageList as $image) {
                $imagePathList[$image->item_id] = $image->path;
            }

            for ($i = 0; $i < count($productList); $i++)
            {
                $productList[$i] += ['imagePath' => $imagePathList[$productList[$i]['id']]];
            }
        }
        return $productList;
    }

    public static function getMaxPage(string $tag, string $search = '')
    {
        $itemsPerPage = ConfigurationServices::option('CATALOG_ITEM_LIMIT');
        $item = new Item();
        if($tag !== 'all')
        {
            $condition = "ALIAS = '$tag'";
            if ($search !== '')
            {
                $condition .= " AND ITEM_NAME like '%$search%'";
            }

            $fullProductList = $item->tags()->find([
                'conditions' =>  $condition
            ]);
        }
        else
        {
            if ($search !== '')
            {
                $fullProductList = $item->find([
                    'conditions' =>  "ITEM_NAME like '%$search%'"
                ]);
            }
            else
            {
                $fullProductList = $item->findAll();
            }
        }
        return ceil(count($fullProductList)/$itemsPerPage);
    }
}