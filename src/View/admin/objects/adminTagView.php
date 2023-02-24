<?php
/**
 * @var Tag $tag
 * @var int $token
 */

use Models\Tag;

?>

<div class="container d-flex flex-column shadow p-3 my-5 bg-white rounded">
	<div>
		<form method="post">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="token" value="<?= $token?>">

			<div class="form-group mb-2">
				<label class="form-label">Название</label>
				<input class="form-control" type="text" name="tag_name" value="<?= $tag->tag_name ?>">
			</div>

			<div class="form-group mb-2">
				<label class="form-label">Ссылка</label>
				<input class="form-control" type="text" name="alias" value="<?= $tag->alias ?>">
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
				<button type="submit" class="btn btn-danger">Удалить тег</button>
			</form>
		</div>
	</div>
</div>

