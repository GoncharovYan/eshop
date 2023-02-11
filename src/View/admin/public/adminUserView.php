<?php
/**
 * @var User $user
 */
use Models\User;
?>

<div>
	<form action="edit/" method="post" style='display: flex; flex-direction: column;'>
		<label style="margin-left: 50px;">Email</label>
		<input type="email" name="email" value="<?= $user->email ?>">
		<label style="margin-left: 50px;">Логин</label>
		<input type="text" name="login" value="<?= $user->login ?>">
		<label style="margin-left: 50px;">Пароль</label>
		<input type="password" name="password" value="<?= $user->password ?>">
		<label style="margin-left: 50px;">Админ</label>

		<input type="checkbox" name="role" <?= !($user->role) ? 'checked' : '' ?>>
		<input type="submit" value="Подтвердить">
	</form>
</div>

<div>
	<form method="post" action="delete/">
		<input type="submit" value="Удалить пользователя">
	</form>
</div>
