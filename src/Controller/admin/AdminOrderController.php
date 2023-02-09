<?php

namespace Controller\admin;

use Controller\BaseController;
use Models\Image;
use Models\Item;
use Models\Orders;

class AdminOrderController extends BaseController
{
	public function adminOrderPage(int|string $id)
	{
		if ($id === 'new') {
			header("Location: /admin/order-list/1/");
		}
		$order = Orders::findById($id);
		$orderProductList = Item::executeQuery(
			"SELECT item.ID, ITEM_NAME, item_order.COUNT FROM orders
				INNER JOIN item_order ON orders.ID = item_order.ORDER_ID
				INNER JOIN item on item_order.ITEM_ID = item.ID
				WHERE orders.ID = $id"
		);

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/public/adminOrderView.php', [
				'order' => $order,
				'orderProductList' => $orderProductList,
			]),
		]);
	}

	public function adminOrderAddProduct($id, $data)
	{
		$item_id = $data['item_id'];
		$query =
			"INSERT IGNORE INTO item_order (ITEM_ID, ORDER_ID) 
			VALUE ($item_id, $id)
			ON DUPLICATE KEY UPDATE    
			COUNT = COUNT + 1";
		Item::executeQuery($query);
		header("Location: /admin/order/$id/");
	}

	public function adminOrderDeleteProduct($id, $data)
	{
		$item_id = $data['product_id'];
		$query =
			"DELETE FROM item_order
			WHERE ORDER_ID = $id AND ITEM_ID = $item_id";
		Orders::executeQuery($query);
		header("Location: /admin/order/$id/");
	}

	public function adminOrderEdit($id, $data)
	{
		$customer_name = $data['customer_name'];
		$c_phone = $data['c_phone'];
		$c_email = $data['c_email'];
		$comment = $data['comment'];
		$price = $data['price'];
		$address = $data['address'];
		$status = ($data['status'] === 'on') ? 1 : 0;

		$query =
			"UPDATE orders
			SET CUSTOMER_NAME = '$customer_name',
				C_PHONE = '$c_phone',
				C_EMAIL = '$c_email',
				COMMENT = '$comment',
				PRICE = '$price',
				ADDRESS = '$address',
				STATUS = $status
			WHERE ID = $id";
		Orders::executeQuery($query);

		header("Location: /admin/order/$id/");
	}

	public function adminOrderDelete($id)
	{
		$query =
			"DELETE FROM item_order
			WHERE ORDER_ID = $id";
		Orders::executeQuery($query);
		$query =
			"DELETE FROM orders
			WHERE ID = $id";
		Orders::executeQuery($query);
		header("Location: /admin/order-list/1/");
	}
}