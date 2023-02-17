<?php
/**
 * @var Image $image
 */

use Models\Image;

?>


<div class="container d-flex shadow p-3 my-5 bg-white rounded admin-image">
	<img src="<?= $image->path ?>" class="main-image img-thumbnail">
	<div class="d-flex flex-column m-3 w-75">
		<div>
			<form method="post" style='display: flex; flex-direction: column;'>
				<input type="hidden" name="action" value="edit">

				<div class="form-group mb-2">
					<label class="form-label">Путь</label>
					<input class="form-control" type="text" name="path" value="<?= $image->path ?>">
				</div>

				<div class="form-group mb-2">
					<label class="form-label">Высота</label>
					<input class="form-control" type="number" name="height" value="<?= $image->height ?>">
				</div>

				<div class="form-group mb-2">
					<label class="form-label">Ширина</label>
					<input class="form-control" type="number" name="width" value="<?= $image->width ?>">
				</div>

				<div class="form-group mb-2">
					<label class="form-label">ID товара</label>
					<input class="form-control" type="number" name="item_id" value="<?= $image->item_id ?>">
				</div>
		</div>

		<div class="d-flex justify-content-evenly p-3">
			<div>
				<button type="submit" class="btn btn-primary">Сохранить изменения</button>
				</form>
			</div>

			<div>
				<form method="post">
					<input type="hidden" name="action" value="delete">
					<button type="submit" class="btn btn-danger">Удалить изображение</button>
				</form>
			</div>
		</div>
	</div>
</div>


