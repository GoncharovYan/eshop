<?php

namespace Controller\public;

use Controller\BaseController;
use Models\Item;

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

            $productsIdString = implode(",", $productsIdArray);

            $items = Item::find([
                'conditions' => "ID IN ($productsIdString)",
            ]);

            echo $this->render('layoutView.php', [
                'content' => $this->render('public/orderView.php', [
                    'items' => $items,
                    'counts' => $cart,
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

    public function isEmptyCart()
    {
        session_start();

        if (!isset($_SESSION['cart']))
            return true;
        else
            return false;
    }
}