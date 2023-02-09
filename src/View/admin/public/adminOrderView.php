<?php
/**
 * @var Orders $order
 * @var array $orderProductList
 */
use Models\Orders;
var_dump($order);
?>

<div>
	<form action="edit/" method="post" style='display: flex; flex-direction: column;'>
		<label style="margin-left: 50px;">Имя заказчика</label>
		<textarea name="customer_name"><?= $order->customer_name ?></textarea>
		<label style="margin-left: 50px;">Телефон заказчика</label>
		<textarea name="c_phone"><?= $order->c_phone ?></textarea>
		<label style="margin-left: 50px;">email заказчика</label>
		<textarea name="c_email"><?= $order->c_email ?></textarea>
		<label style="margin-left: 50px;">Комментарий</label>
		<textarea name="c_email"><?= $order->comment ?></textarea>
		<label style="margin-left: 50px;">Стоимость заказа</label>
		<input type="number" name="price" value="<?= $order->price ?>">
		<label style="margin-left: 50px;">Адрес доставки</label>
		<input type="text" name="address" value="<?= $order->address ?>">
		<label style="margin-left: 50px;">Закрыт</label>
		<input type="checkbox" name="status" <?= $order->status ? 'checked' : '' ?>>
		<input type="submit" value="Подтвердить">
	</form>
</div>

<div>
	<p style="margin-left: 50px;">Товары в заказе</p>
	<? foreach ($orderProductList as $orderProduct) { ?>
		<form method="post" action="delete-product/">
			<label><?= $orderProduct->count ?></label>
			<label><?= $orderProduct->item_name ?></label>
			<input type="hidden" name="product_id" value="<?= $orderProduct->id ?>">
			<input type="submit" value="Удалить">
		</form>
	<? } ?>
	<form method="post" action="add-product/">
		<label>Добавить товар по id</label>
		<input type="text" name="item_id">
		<input type="submit" value="Добавить">
	</form>
</div>

<div>
	<form method="post" action="delete/">
		<input type="submit" value="Удалить заказ">
	</form>
</div>

