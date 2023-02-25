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

		if (!is_numeric($id)){
			if($id === 'new'){
				$order = new Orders();
				$items = [];
			} else {
				echo 'order not found';
				exit;
			}
		} else {
			$order = Orders::findById($id);
			if(is_null($order)){
				echo 'order not found';
				exit;
			}
			$item = new Item();
			$items = $item->orders()->find([
				'conditions' => "ORDERS_ID = $id"
			]);
		}

		echo $this->render('admin/layoutView.php', [
			'content' => $this->render('admin/objects/adminOrderView.php', [
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
			case "delete":
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