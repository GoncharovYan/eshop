<?php
/**
 * @var Item $item
 * @var array $images
 * @var array $tags
 */

use Models\Item;
?>

<div>
	<form action="edit/" method="post" style='display: flex; flex-direction: column;'>
		<label style="margin-left: 50px;">Название</label>
		<textarea name="item_name"><?= $item->item_name ?></textarea>
		<label style="margin-left: 50px;">Краткое описание</label>
		<textarea name="short_desc"><?= $item->short_desc ?></textarea>
		<label style="margin-left: 50px;">Полное описание</label>
		<textarea name="full_desc"><?= $item->full_desc ?></textarea>
		<label style="margin-left: 50px;">Количество</label>
		<input type="number" name="count" value="<?= $item->count ?>">
		<label style="margin-left: 50px;">Цена</label>
		<input type="number" name="price" value="<?= $item->price ?>">
		<label style="margin-left: 50px;">
			Активен
			<input type="radio" name="is_active" value="1" <?= $item->is_active ? 'checked' : '' ?>>
			Неактивен
			<input type="radio" name="is_active" value="0" <?= $item->is_active ? '' : 'checked' ?>>
		</label>
		<input type="submit" value="Подтвердить">
	</form>
</div>

<div>
	<p style="margin-left: 50px;">Теги</p>
	<? foreach ($tags as $tag) { ?>
		<form method="post" action="delete-tag/">
			<label><?= $tag['tag_name'] ?></label>
			<input type="hidden" name="tag_id" value="<?= $tag['id'] ?>">
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
	<? foreach ($images as $image) { ?>
		<form method="post" action="delete-image/">
			<img src="<?= $image['path'] ?>" style="height: 200px; width: 200px">
			<input type="hidden" name="image_id" value="<?= $image['id'] ?>">
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

