<?php
/**
 * @var Item $item
 * @var Image $mainImage
 * @var array $images
 * @var array $tags
 * @var array $allTags
 * @var int $token
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
				<input type="hidden" name="main_image_id" value="<?= $mainImage->id ?>">
				<input type="hidden" name="token" value="<?= $token?>">

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

	<h4 class="text-center">Теги</h4>

	<div class="tag">
		<div class="m-1 d-flex align-items-center">
			<input type="search" id="elastic-tag" class="form-control" placeholder="Поиск тега">
		</div>

		<div class="d-flex justify-content-around m-3 h-100">
			<div class="list-group" style="width: 30%">
				<div class="border h-100 overflow-auto h-50">
					<form method="post">
						<input type="hidden" name="action" value="deleteRelations">
						<input type="hidden" name="relation" value="tag">
						<input type="hidden" name="token" value="<?= $token?>">
						<ul class="elastic-tag list-group">
							<? foreach ($tags as $tag) { ?>
								<li class="list-group-item m-1 justify-content-between">
									<label><?= $tag['tag_name'] ?></label>
									<input type="checkbox" name="id[]" value="<?= $tag['id'] ?>">
								</li>
							<? } ?>
						</ul>
				</div>
				<div class="p-3 d-flex justify-content-center">
					<input type="submit" value="Удалить выбранное" class="btn btn-danger">
					</form>
				</div>
			</div>

			<div class="list-group" style="width: 30%">
				<div class="border h-100 overflow-auto h-50">
					<form method="post">
						<input type="hidden" name="action" value="addRelations">
						<input type="hidden" name="relation" value="tag">
						<input type="hidden" name="token" value="<?= $token?>">
						<ul class="elastic-tag list-group">
							<? foreach ($allTags as $tag) { ?>
								<li class="list-group-item m-1 justify-content-between">
									<?= $tag->tag_name ?>
									<input type="checkbox" name="id[]" value="<?= $tag->id ?>">
								</li>
							<? } ?>
						</ul>
				</div>
				<div class="p-3 d-flex justify-content-center">
					<input type="submit" value="Добавить выбранное" class="btn btn-success">
					</form>
				</div>
			</div>
		</div>
	</div>


	<h4 class="text-center p-2 mt-5">Изображения</h4>

	<div class="d-flex overflow-auto border">
		<? foreach ($images as $image) { ?>
			<div class="d-flex flex-column p-3 bg-white rounded h-100 border" style="width: 235px">
				<img src="<?= $image->path ?>" class="additional-image ">
				<div class="d-flex w-100 justify-content-between">
					<form method="post">
						<input type="hidden" name="action" value="deleteImage">
						<input type="hidden" name="id" value="<?= $image->id ?>">
						<input type="hidden" name="token" value="<?= $token?>">
						<button type="submit" class="btn btn-danger">Удалить</button>
					</form>
					<form method="post">
						<input type="hidden" name="action" value="editMainImage">
						<input type="hidden" name="main_image_id" value="<?= $image->id ?>">
						<input type="hidden" name="token" value="<?= $token?>">
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
			<input type="hidden" name="token" value="<?= $token?>">
			<input type="file" name="image" accept="image/*" class="form-control">
			<button type="submit" class="btn btn-primary">Отправить</button>
		</form>
	</div>

	<div class="p-3 d-flex justify-content-center">
		<form method="post">
			<input type="hidden" name="action" value="delete">
			<input type="hidden" name="token" value="<?= $token?>">
			<button type="submit" class="btn btn-danger">Удалить товар</button>
		</form>
	</div>
</div>

<!-- Перенести в .js файл -->
<script>
	document.querySelector('#elastic-tag').oninput = function () {
		let val = this.value.trim();
		let elasticItems = document.querySelectorAll('.elastic-tag li');
		if (val !== '') {
			elasticItems.forEach(function (elem) {
				if (elem.innerText.search(val) === -1) {
					elem.classList.add('hide');
				} else {
					elem.classList.remove('hide');
				}
			});
		} else {
			elasticItems.forEach(function (elem) {
				elem.classList.remove('hide');
			});
		}
	}
</script>


