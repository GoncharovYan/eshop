<?php
/**
 * @var Orders $order
 * @var array $orderItems
 * @var array $itemsCount
 */

use Models\Orders;

?>

<div class="container d-flex flex-column shadow p-3 my-5 bg-white rounded order">
	<div>
		<form method="post" class="d-flex flex-column">
			<input type="hidden" name="action" value="edit">

			<div class="form-group mb-2">
				<label class="form-label">Имя заказчика</label>
				<input class="form-control" type="text" name="customer_name" value="<?= $order->customer_name ?>">
			</div>

			<div class="form-group mb-2">
				<label class="form-label">Телефон заказчика</label>
				<input class="form-control" type="text" name="c_phone" value="<?= $order->c_phone ?>">
			</div>

			<div class="form-group mb-2">
				<label class="form-label">email заказчика</label>
				<input class="form-control" type="text" name="c_email" value="<?= $order->c_email ?>">
			</div>

			<div class="form-group mb-2">
				<label class="form-label">Комментарий</label>
				<textarea class="form-control" name="comment"><?= $order->comment ?></textarea>
			</div>

			<div class="form-group mb-2">
				<label class="form-label">Адрес доставки</label>
				<input class="form-control" type="text" name="address" value="<?= $order->address ?>">
			</div>

			<div class="d-flex form-group mb-2">
				<div class="form-group mb-2 w-25">
					<label class="form-label">Стоимость заказа</label>
					<input class="form-control" type="number" name="price" value="<?= $order->price ?>">
				</div>

				<div class="d-flex w-25 align-items-center justify-content-evenly">
					<div class="form-check">
						<input class="form-check-input" type="radio" name="status"
							   value="0" <?= $order->status ? '' : 'checked' ?>>
						<label class="form-check-label">
							Открыт
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="status"
							   value="1" <?= $order->status ? 'checked' : '' ?>>
						<label class="form-check-label">
							Закрыт
						</label>
					</div>
				</div>
			</div>
			<div class="d-flex justify-content-center">
				<button type="submit" class="btn btn-primary">Сохранить изменения</button>
			</div>
		</form>
	</div>

	<h4 class="text-center pt-2">Товары в заказе</h4>


	<div class="items container overflow-auto border">
		<? foreach ($orderItems as $orderItem) { ?>
			<div class="row w-100 p-1">
				<div class="col">
					<form method="post">
						<input type="hidden" name="action" value="editOrderCount">
						<input type="hidden" name="relation" value="item">

						<label><?= $orderItem['item_name'] ?></label>

						<input type="hidden" name="id" value="<?= $orderItem['id'] ?>">
				</div>
				<div class="col form-check d-flex align-items-end">
					<label class="form-label w-25">Кол-во</label>
					<input class="form-control" type="number" name="item_count" value="<?= $orderItem['item_count'] ?>">
				</div>
				<div class="col d-flex">
					<button type="submit" class="btn btn-primary">Изменить</button>
					</form>
					<form method="post">
						<input type="hidden" name="action" value="deleteRelation">
						<input type="hidden" name="relation" value="item">
						<input type="hidden" name="id" value="<?= $orderItem['id'] ?>">
						<button type="submit" class="btn btn-danger">Удалить</button>
					</form>
				</div>
			</div>
		<? } ?>
	</div>

	<form method="post" class="p-3">
		<label>Добавить товар по id</label>
		<input type="hidden" name="action" value="addRelation">
		<input type="hidden" name="relation" value="item">
		<input type="text" name="id">
		<button type="submit" class="btn btn-primary">Добавить</button>
	</form>

	<div class="p-3 d-flex justify-content-center">
		<form method="post">
			<input type="hidden" name="action" value="delete">
			<button type="submit" class="btn btn-danger">Удалить заказ</button>
		</form>
	</div>
</div>
