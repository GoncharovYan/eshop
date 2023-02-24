<?php

namespace Controller\public;

use Controller\BaseController;
use Core\Web\Json;
use Models\Item;
use Models\Orders;
use Services\TokenServices;

class OrderController extends BaseController
{
    public function orderPage()
    {
        session_start();

        if (!empty($_SESSION['cart']))
        {
            $cart = $_SESSION['cart'];

            $productsIdArray = array_keys($cart);
            $cost = 0;

            $productsIdString = implode(",", $productsIdArray);

            $items = Item::find([
                'conditions' => "ID IN ($productsIdString)",
            ]);

            foreach ($items as $item)
            {
                $cost += $item->price * $cart[(int)$item->id];
            }

            $_SESSION['total_cost'] = $cost;

            if (isset($_SESSION['login']))
            {
                $email = $_SESSION['email'];
            }
            else
            {
                $email = null;
            }

			$token = TokenServices::createToken();

            echo $this->render('layoutView.php', [
                'content' => $this->render('public/orderView.php', [
                    'items' => $items,
                    'counts' => $cart,
                    'email' => $email,
                    'cost' => $cost,
					'token' => $token,
                ]),
            ]);
        }
        else
        {
            echo $this->render('layoutView.php', [
                'content' => "<p>Корзина пустая :(</p>",
            ]);
        }
    }

    public function modifyCart()
    {
        session_start();

        $data = Json::decode(file_get_contents('php://input'));

        $id = $data['id'];
        $count = $data['count'];

        if (!isset($_SESSION['cart'][$id]))
        {
            if ($count < 1) return;

            $_SESSION['cart'][$id] = $count;
            return;
        }

        $_SESSION['cart'][$id] = $_SESSION['cart'][$id] + $count;

        if ($_SESSION['cart'][$id] < 1)
        {
            unset($_SESSION['cart'][$id]);
        }

        echo Json::encode([
            'id' => $id,
            'count' => $count,
        ]);
    }

    public function deleteFromCart()
    {
        session_start();

        $data = Json::decode(file_get_contents('php://input'));

        $id = $data['id'];

        unset($_SESSION['cart'][$id]);

        echo Json::encode([
            'id' => $id,
        ]);
    }

    public function checkout($data)
    {
        session_start();

		$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
		TokenServices::checkToken($token, $_SESSION['token'], "Извините, мы не можем принять ваш заказ");

        $newOrder = new Orders();

        $newOrder->customer_name = $data['name'];
        $newOrder->c_phone = $data['phone'];
        $newOrder->c_email = $data['email'];
        $newOrder->address = $data['address'];
        $newOrder->comment = $data['comment'];
        $newOrder->status = 0;
        $newOrder->price = $_SESSION['total_cost'];

        $order = $newOrder->save();

        $cart = $_SESSION['cart'];

        $productIdArr = array_keys($cart);

        $products = Item::findByIdArr($productIdArr);

        $order->addRelationArr($products, "ITEM_COUNT", $cart);

        echo $this->render('layoutView.php', [
            'content' => "<p>ну всё жди. скоро будем</p>",
        ]);

       // header('Location: /catalog/all/1/');
    }

}