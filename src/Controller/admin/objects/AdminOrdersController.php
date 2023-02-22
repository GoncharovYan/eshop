<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Item;
use Models\Orders;

class AdminOrdersController extends BaseController
{
	public function adminOrdersPage(int|string $id)
	{
		if ($id === 'new') {
			$order = new Orders();
			$items = [];
		} else {
			$order = Orders::findById($id);
			$item = new Item();
			$items = $item->orders()->find([
				'conditions' => "ORDERS_ID = $id"
			]);
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminOrderView.php', [
				'order' => $order,
				'orderItems' => $items,
			]),
		]);
	}
}