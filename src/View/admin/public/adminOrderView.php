<?php
/**
 * @var Orders $order
 * @var array $orderItems
 * @var array $itemsCount
 */

use Models\Orders;

?>

<div>
	<form method="post" style='display: flex; flex-direction: column;'>
		<input type="hidden" name="action" value="edit">
		<label style="margin-left: 50px;">Имя заказчика</label>
		<textarea name="customer_name"><?= $order->customer_name ?></textarea>
		<label style="margin-left: 50px;">Телефон заказчика</label>
		<textarea name="c_phone"><?= $order->c_phone ?></textarea>
		<label style="margin-left: 50px;">email заказчика</label>
		<textarea name="c_email"><?= $order->c_email ?></textarea>
		<label style="margin-left: 50px;">Комментарий</label>
		<textarea name="comment"><?= $order->comment ?></textarea>
		<label style="margin-left: 50px;">Стоимость заказа</label>
		<input type="number" name="price" value="<?= $order->price ?>">
		<label style="margin-left: 50px;">Адрес доставки</label>
		<input type="text" name="address" value="<?= $order->address ?>">
		<label style="margin-left: 50px;">
			Открыт
			<input type="radio" name="status" value="0" <?= $order->status ? '' : 'checked' ?>>
			Закрыт
			<input type="radio" name="status" value="1" <?= $order->status ? 'checked' : '' ?>>
		</label>
		<input type="submit" value="Подтвердить">
	</form>
</div>

<div>
	<p style="margin-left: 50px;">Товары в заказе</p>
	<? foreach ($orderItems as $orderItem) { ?>
		<label style="display: flex">
			<form method="post">
				<input type="hidden" name="action" value="editOrderCount">
				<input type="hidden" name="relation" value="item">
				<label>
					Кол-во
					<input type="number" name="item_count" value="<?= $orderItem['item_count'] ?>">
				</label>
				<label><?= $orderItem['item_name'] ?></label>
				<input type="hidden" name="id" value="<?= $orderItem['id'] ?>">
				<input type="submit" value="Изменить">
			</form>
			<form method="post">
				<input type="hidden" name="action" value="deleteRelation">
				<input type="hidden" name="relation" value="item">
				<input type="hidden" name="id" value="<?= $orderItem['id'] ?>">
				<input type="submit" value="Удалить">
			</form>
		</label>
	<? } ?>
	<form method="post">
		<label>Добавить товар по id</label>
		<input type="hidden" name="action" value="addRelation">
		<input type="hidden" name="relation" value="item">
		<input type="text" name="id">
		<input type="submit" value="Добавить">
	</form>
</div>

<div>
	<form method="post">
		<input type="hidden" name="action" value="delete">
		<input type="submit" value="Удалить заказ">
	</form>
</div>

