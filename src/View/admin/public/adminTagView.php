<?php
/**
 * @var Tag $tag
 */
use Models\Tag;
?>

<div>
	<form method="post" style='display: flex; flex-direction: column;'>
		<input type="hidden" name="action" value="edit">
		<label style="margin-left: 50px;">Название</label>
		<textarea name="tag_name"><?= $tag->tag_name ?></textarea>
		<label style="margin-left: 50px;">Ссылка</label>
		<textarea name="alias"><?= $tag->alias ?></textarea>
		<input type="submit" value="Подтвердить">
	</form>
</div>

<div>
	<form method="post">
		<input type="hidden" name="action" value="delete">
		<input type="submit" value="Удалить тег">
	</form>
</div>
