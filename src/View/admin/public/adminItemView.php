<?php
/**
 * @var Item $item
 * @var Image $mainImage
 * @var array $images
 * @var array $tags
 * @var array $allTags
 */

use Models\Image;
use Models\Item;

?>

<div class="container d-flex flex-column shadow p-3 my-5 bg-white rounded item" xmlns="http://www.w3.org/1999/html">
	<div class="d-flex justify-content-between">
		<img src="<?= $mainImage->path ?>" class="img-thumbnail main-image">
		<div class="w-75">
			<form method="post">
				<input type="hidden" name="action" value="edit">

				<div class="p-3">
					<label class="form-label">Название</label>
					<input type="text" name="item_name" class="form-control" value="<?= $item->item_name ?>">
				</div>

				<div class="d-flex">
					<div class="p-3">
						<label class="form-label">Количество</label>
						<input type="number" name="count" class="form-control" value="<?= $item->count ?>">
					</div>
					<div class="p-3">
						<label class="form-label">Цена</label>
						<input type="number" name="price" class="form-control" value="<?= $item->price ?>">
					</div>
					<div class="p-3">
						<label class="form-label">Порядок сортировки</label>
						<input type="number" name="sort_order" class="form-control" value="<?= $item->sort_order ?>">
					</div>
				</div>

				<div class="d-flex p-3">
					<div class="form-check">
						<input class="form-check-input" type="radio" name="is_active"
							   value="1" <?= $item->is_active ? 'checked' : '' ?>>
						<label class="form-check-label">
							Активен
						</label>
					</div>
					<div class="form-check ms-3">
						<input class="form-check-input" type="radio" name="is_active"
							   value="0" <?= $item->is_active ? '' : 'checked' ?>>
						<label class="form-check-label">
							Неактивен
						</label>
					</div>
				</div>

				<div class="p-3">
					<label class="form-label">Краткое описание</label>
					<input type="text" name="short_desc" class="form-control" value="<?= $item->short_desc ?>">
				</div>
		</div>
	</div>

	<div class="p-3">
		<label>Полное описание</label>
		<textarea name="full_desc" class="form-control"><?= $item->full_desc ?></textarea>
	</div>

	<div class="p-3 d-flex justify-content-center">
		<button type="submit" class="btn btn-primary">Сохранить изменения</button>
	</div>
	</form>

	<h4 class="text-center pt-2">Теги</h4>

	<div class="tag d-flex justify-content-around m-3">
		<ul class="overflow-auto list-group " style="width: 30%">
			<? foreach ($tags as $tag) { ?>
				<form method="post">
					<li class="list-group-item m-1 d-flex justify-content-between">
						<label><?= $tag['tag_name'] ?></label>
						<input type="hidden" name="action" value="deleteRelation">
						<input type="hidden" name="relation" value="tag">
						<input type="hidden" name="id" value="<?= $tag['id'] ?>">
						<input type="submit" value="-" class="btn btn-danger">
					</li>
				</form>
			<? } ?>
		</ul>

		<div class="h-100 overflow-auto" style="width: 30%">
			<div class="m-1">
				<input type="search" id="elastic-tag" class="form-control" placeholder="Поиск тега">
			</div>

			<ul class="elastic list-group">
				<? foreach ($allTags as $tag) { ?>
					<form method="post">
						<li class="list-group-item m-1 d-flex justify-content-between">
							<?= $tag->tag_name ?>
							<input type="hidden" name="action" value="addRelation">
							<input type="hidden" name="relation" value="tag">
							<input type="hidden" name="id" value="<?= $tag->id ?>">
							<input type="submit" value="+" class="btn btn-success">
						</li>
					</form>
				<? } ?>
			</ul>
		</div>
	</div>

	<h4 class="text-center pt-2">Изображения</h4>

	<div class="d-flex overflow-auto">
		<? foreach ($images as $image) { ?>
			<div class="d-flex flex-column p-3 bg-white rounded h-100 border" style="width: 235px">
				<img src="<?= $image->path ?>" class="additional-image ">
				<div class="d-flex w-100 justify-content-between">
					<form method="post">
						<input type="hidden" name="action" value="deleteImage">
						<input type="hidden" name="id" value="<?= $image->id ?>">
						<button type="submit" class="btn btn-danger">Удалить</button>
					</form>
					<form method="post">
						<input type="hidden" name="action" value="edit">
						<input type="hidden" name="main_image_id" value="<?= $image->id ?>">
						<button type="submit"
								class="btn <?= $item->main_image_id === $image->id ? 'btn-success' : 'btn-secondary' ?>">
							Главное
						</button>
					</form>
				</div>
			</div>
		<? } ?>
	</div>

	<div class="p-3">
		<label class="form-label">Добавить изображение</label>
		<form method="post" enctype="multipart/form-data" class="d-flex">
			<input type="hidden" name="action" value="addImage">
			<input type="file" name="image" accept="image/*" class="form-control">
			<button type="submit" class="btn btn-primary">Отправить</button>
		</form>
	</div>

	<div class="p-3 d-flex justify-content-center">
		<form method="post">
			<input type="hidden" name="action" value="delete">
			<button type="submit" class="btn btn-danger">Удалить товар</button>
		</form>
	</div>
</div>


<!-- Перенести в .js файл -->
<script>
	document.querySelector('#new-image-path').oninput = function () {
		let val = this.value;
		let elem = document.querySelector('.');
		if (val !== '') {
			function (elem) {
				elem.classList.add('hide');
			}
			}
		} else {
			elem.classList.remove('hide');
		}
	}
</script>


