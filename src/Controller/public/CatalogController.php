<?php

namespace Controller\public;

use Controller\BaseController;
use Core\Web\Json;
use Models\Tag;
use Services\CatalogServices;
use Validation\Validator;

class CatalogController extends BaseController
{
	public function catalogPage(string $tag = null, int $curPage = null)
	{
		if ($curPage === null)
		{
			if ($tag === null || is_numeric($tag))
			{
				$tag = 'all';
			}
			header("Location: /catalog/{$tag}/1/");
		}
		else
		{
			$messages = [];

			$tagList = Tag::find(['limit' => '10']);
			$search = $_GET['search'] ?? '';
			$val = new Validator();
			if ($search)
			{
				$val->checkText($search, 'поиск', 100);
				if (!$val->isSuccess())
				{
					$messages = $val->getErrors();
					$productList = [];
					$maxPage = null;
				}
			}
			if ($val->isSuccess())
			{
				$productList = CatalogServices::getCatalogProducts($tag, $curPage, $search);
				$maxPage = CatalogServices::getMaxPage($tag, $search);
			}
			$paginator = [
				'curPage' => $curPage,
				'maxPage' => $maxPage,
			];

			echo $this->render('layoutView.php', [
			    'tag' => $tag,
				'messages' => $messages,
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
		$search = strval($search);
		if ($search)
		{
			$val = new Validator();
			$val->checkText($search, 'поиск', 100);
			if (!$val->isSuccess())
			{
				$search = '';
			}
		}
		$productList = CatalogServices::getCatalogProducts($tag, $curPage, $search);
		$catalogList = [];
		foreach ($productList as $product)
		{
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


