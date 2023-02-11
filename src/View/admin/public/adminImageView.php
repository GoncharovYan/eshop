<?php
/**
 * @var Image $image
 */

use Models\Image;
?>

<div>
	<img src="<?=$image->path ?>">
</div>

<div>
	<form action="edit/" method="post" style='display: flex; flex-direction: column;'>
		<label style="margin-left: 50px;">Путь</label>
		<textarea name="path"><?= $image->path ?></textarea>
		<label style="margin-left: 50px;">Высота</label>
		<textarea name="height"><?= $image->height ?></textarea>
		<label style="margin-left: 50px;">Ширина</label>
		<textarea name="width"><?= $image->width ?></textarea>
		<input type="submit" value="Подтвердить">
	</form>
</div>

<div>
	<form method="post" action="delete/">
		<input type="submit" value="Удалить изображение">
	</form>
</div>
