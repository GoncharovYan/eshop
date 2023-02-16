<?php
/**
 * @var Item $item
 * @var Image $mainImage
 * @var array $images
 * @var array $tags
 */

use Models\Image;
use Models\Item;

?>

<div>
	<img src="<?= $mainImage->path ?>">
</div>

<div>
	<form method="post" style='display: flex; flex-direction: column;'>
		<input type="hidden" name="action" value="edit">
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
		<form method="post">
			<label><?= $tag['tag_name'] ?></label>
			<input type="hidden" name="action" value="deleteRelation">
			<input type="hidden" name="relation" value="tag">
			<input type="hidden" name="id" value="<?= $tag['id'] ?>">
			<input type="submit" value="Удалить">
		</form>
	<? } ?>
	<form method="post">
		<label>Добавить тег по id</label>
		<input type="hidden" name="action" value="addRelation">
		<input type="hidden" name="relation" value="tag">
		<input type="text" name="id">
		<input type="submit" value="Добавить">
	</form>
</div>

<div>
	<p style="margin-left: 50px;">Картинки</p>
	<label style="display: flex">
		<? foreach ($images as $image) { ?>
			<form method="post">
				<img src="<?= $image->path ?>" style="height: 200px; width: 200px">
				<input type="hidden" name="action" value="deleteImage">
				<input type="hidden" name="id" value="<?= $image->id ?>">
				<input type="submit" value="Удалить">
			</form>
		<? } ?>
	</label>
	<label>
		<form method="post">
			<input type="submit" value="Выбрать главное изображение">
			<input type="hidden" name="action" value="edit">
			<? foreach ($images as $image) { ?>
				<input type="radio" name="main_image_id" value="<?= $image->id ?>" <?= $item->main_image_id === $image->id ? 'checked' : '' ?>>
			<? } ?>
		</form>
	</label>
	<div>
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="addImage">
			<input type="file" name="image" accept="image/*">
			<input type="submit" value="Отправить">
		</form>
	</div>
</div>

<div>
	<form method="post">
		<input type="hidden" name="action" value="delete">
		<input type="submit" value="Удалить товар">
	</form>
</div>

