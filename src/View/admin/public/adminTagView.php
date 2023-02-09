<?php
/**
 * @var Tag $tag
 */
use Models\Tag;
?>

<div>
	<form action="edit/" method="post" style='display: flex; flex-direction: column;'>
		<label style="margin-left: 50px;">Название</label>
		<textarea name="tag_name"><?= $tag->tag_name ?></textarea>
		<label style="margin-left: 50px;">Ссылка</label>
		<textarea name="alias"><?= $tag->alias ?></textarea>
		<input type="submit" value="Подтвердить">
	</form>
</div>

<div>
	<form method="post" action="delete/">
		<input type="submit" value="Удалить тег">
	</form>
</div>
