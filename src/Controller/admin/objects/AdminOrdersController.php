<?php

namespace Controller\admin\objects;

use Controller\BaseController;
use Models\Item;
use Models\Orders;
use Services\AdminServices;
use Services\AdminValidateServices;
use Services\TokenServices;
use Services\UserServices;

class AdminOrdersController extends BaseController
{
	public function adminOrdersPage(int|string $id)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

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
				'token' => TokenServices::createToken(),
			]),
		]);
	}

	public function adminOrdersEdit($id, $data)
	{
		if (!UserServices::isAdmin()) {
			header("Location: /catalog/all/1/");
			exit;
		}

		session_start();
		TokenServices::checkToken($data['token'], $_SESSION['token'], "Bad token");

		switch ($data['action']) {
			case "edit":
				AdminValidateServices::adminOrderEditValidate($data);
				break;
			case "deleteRelations":
				AdminValidateServices::adminRelationsValidate($data);
				break;
			case "updateItemCount":
				AdminValidateServices::adminUpdateRelationsValidate($data);
				break;
			case "addRelation":
				AdminValidateServices::adminRelationValidate($data);
				break;
			default:
				echo 'Wrong action';
				exit();
		}
		AdminServices::adminEditAction('orders', $id, $data);
	}
}