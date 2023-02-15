<?php
namespace Controller\public;

use Controller\BaseController;
use Models\Item;

class CheckoutController extends BaseController
{
    public function checkoutPage()
    {
        session_start();


        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            $productsIdArray = array_keys($cart);
            $cost = 0;

            $productsIdString = implode(",", $productsIdArray);

            $items = Item::find([
                'conditions' => "ID IN ($productsIdString)",
            ]);

            foreach ($items as $item)
            {
                for($i = 0; $i < $cart[(int)$item->id]; $i++)
                {
                    $cost += $item->price;
                }

            }


        }

        if (isset($_SESSION['login']))
        {
            $email = $_SESSION['email'];
        }
        else
        {
            $email = null;
        }

        echo $this->render('layoutView.php', [
            'content' => $this->render('/public/checkoutView.php', [
                'email' => $email,
                'cost' => $cost,
                ])
        ]);
    }

}