<?php
/**
 * @var Item $product
 * @var array $productImageList
 * @var array $productTagList
 */

use Models\Item;

?>

<div>
	<form action="edit/" method="post" style='display: flex; flex-direction: column;'>
		<label style="margin-left: 50px;">Название</label>
		<textarea name="item_name"><?= $product->item_name ?></textarea>
		<label style="margin-left: 50px;">Краткое описание</label>
		<textarea name="short_desc"><?= $product->short_desc ?></textarea>
		<label style="margin-left: 50px;">Полное описание</label>
		<textarea name="full_desc"><?= $product->full_desc ?></textarea>
		<label style="margin-left: 50px;">Количество</label>
		<input type="number" name="count" value="<?= $product->count ?>">
		<label style="margin-left: 50px;">Цена</label>
		<input type="number" name="price" value="<?= $product->price ?>">
		<label style="margin-left: 50px;">Активен</label>
		<input type="checkbox" name="is_active" <?= $product->is_active ? 'checked' : '' ?>>
		<input type="submit" value="Подтвердить">
	</form>
</div>

<div>
	<p style="margin-left: 50px;">Теги</p>
	<? foreach ($productTagList as $productTag) { ?>
		<form method="post" action="delete-tag/">
			<label><?= $productTag->tag_name ?></label>
			<input type="hidden" name="tag_id" value="<?= $productTag->id ?>">
			<input type="submit" value="Удалить">
		</form>
	<? } ?>
	<form method="post" action="add-tag/">
		<label>Добавить тег по id</label>
		<input type="text" name="tag_id">
		<input type="submit" value="Добавить">
	</form>
</div>

<div>
	<p style="margin-left: 50px;">Картинки</p>
	<? foreach ($productImageList as $productImage) { ?>
		<form method="post" action="delete-image/">
			<img src="<?= $productImage->path ?>" style="height: 200px; width: 200px">
			<input type="hidden" name="image_id" value="<?= $productImage->id ?>">
			<input type="submit" value="Удалить">
		</form>
	<? } ?>
	<form method="post" action="add-image/">
		<label>Добавить картинку по id</label>
		<input type="text" name="image_id">
		<input type="submit" value="Добавить">
	</form>
</div>

<div>
	<form method="post" action="delete/">
		<input type="submit" value="Удалить товар">
	</form>
</div>

