<?php

namespace Controller\admin;

use Controller\BaseController;
use Models\Image;
use Models\Item;
use Models\Orders;
use Models\Tag;
use Models\User;
use Services\PageServices;

class AdminListController extends BaseController
{
	public function adminItemListPage(int $curPage = null)
	{
		$productList = Item::findAll();

		$itemTable = [];
		$itemTableHead = ['ID', 'Название', 'Стоимость', 'Кол-во', 'Активно', 'Дата создания', 'Дата обновления'];
		foreach ($productList as $product)
		{
			$itemTable[] = [
				'id' => $product->id,
				'name' => $product->item_name,
				'price' => $product->price,
				'count' => $product->count,
				'isActive' => ($product->is_active) ? 'да' : 'нет',
				'dateCreated' => $product->date_created,
				'dateUpdated' => $product->date_updated
			];
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminView.php', [
				'contentTable' => $itemTable,
				'contentTableHead' => $itemTableHead,
				'contentType' => 'product'
			]),
		]);
	}

	public function adminImageListPage(int $curPage = null)
	{
		//Добавить пагинацию
		$imageList = Image::findAll();

		$imageTable = [];
		$imageTableHead = ['ID', 'Путь', 'Высота', 'Ширина', 'Главная'];
		foreach ($imageList as $image)
		{
			$imageTable[] = [
				'id' => $image->id,
				'path' => $image->path,
				'height' => $image->height,
				'width' => $image->width,
				'isMain' => ($image->is_main) ? 'да' : 'нет',
			];
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminView.php', [
				'contentTable' => $imageTable,
				'contentTableHead' => $imageTableHead,
				'contentType' => 'image',
			]),
		]);
	}

	public function adminOrderListPage(int $curPage = null)
	{
		$orderList = Orders::findAll();

		$orderTable = [];
		$orderTableHead = ['ID', 'Заказчик', 'Статус', 'Стоимость', 'Дата создания'];
		foreach ($orderList as $order)
		{
			$orderTable[] = [
				'id' => $order->id,
				'customerName' => $order->customer_name,
				'status' => $order->status,
				'dateCreated' => $order->date_created,
			];
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminView.php', [
				'contentTable' => $orderTable,
				'contentTableHead' => $orderTableHead,
				'contentType' => 'order',
			]),
		]);
	}

	public function adminTagListPage(int $curPage = null)
	{
		$tagList = Tag::findAll();

		$tagTable = [];
		$tagTableHead = ['ID', 'Название'];
		foreach ($tagList as $tag)
		{
			$tagTable[] = [
				'id' => $tag->id,
				'name' => $tag->tag_name
			];
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminView.php', [
				'contentTable' => $tagTable,
				'contentTableHead' => $tagTableHead,
				'contentType' => 'tag',
			]),
		]);
	}

	public function adminUserListPage(int $curPage = null)
	{
		$tagList = User::findAll();

		$userTable = [];
		$userTableHead = ['ID', 'Почта', 'Логин', 'Роль'];
		foreach ($tagList as $user)
		{
			$userTable[] = [
				'id' => $user->id,
				'email' => $user->email,
				'login' => $user->login,
				'role' => ($user->role) ? 'пользователь' : 'админ',
			];
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminView.php', [
				'contentTable' => $userTable,
				'contentTableHead' => $userTableHead,
				'contentType' => 'user',
			]),
		]);
	}
}
