<?php

namespace Controller\public;

use Controller\BaseController;
use Models\Item;
use Models\Orders;
use Models\Relation;
use Services\TokenServices;

class OrderController extends BaseController
{
    public function orderPage()
    {
        //$product = Item::findById($id);
        session_start();

        if (isset($_SESSION['cart']))
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
                'content' => "<p>Товар не найден</p>",
            ]);
        }
    }

    public function addToCart(int $id, int $count = 1)
    {
        session_start();

        $_SESSION['cart'][$id] = $_SESSION['cart'][$id] + $count;

        header("Location: /catalog/all/1/");
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
        //@todo прокид без даты
        $newOrder->date_created = date('Y/m/d h:m:s');
        $newOrder->price = $_SESSION['total_cost'];

        $newOrder->save();

        //@todo придумать что-нибудь умное с таблицей связи...
        //$cart = $_SESSION['cart'];
        //$productsIdArray = array_keys($cart);
        //$productsIdString = implode(",", $productsIdArray);

        //Relation::executeQuery(
        //    "INSERT INTO item_order VALUES ()"
        //)


        echo $this->render('layoutView.php', [
            'content' => "<p>ну всё жди. скоро будем</p>",
        ]);


       // header('Location: /catalog/all/1/');
    }
}