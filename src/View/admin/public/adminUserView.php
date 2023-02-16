<?php
/**
 * @var User $user
 */
use Models\User;
?>

<div>
	<form method="post" style='display: flex; flex-direction: column;'>
		<input type="hidden" name="action" value="edit">
		<label style="margin-left: 50px;">Email</label>
		<input type="email" name="email" value="<?= $user->email ?>">
		<label style="margin-left: 50px;">Логин</label>
		<input type="text" name="login" value="<?= $user->login ?>">
		<label style="margin-left: 50px;">Пароль</label>
		<input type="password" name="password" value="<?= $user->password ?>">
		<label style="margin-left: 50px;">
			Админ
			<input type="radio" name="role" value="0" <?= $user->role ? '' : 'checked' ?>>
			Пользователь
			<input type="radio" name="role" value="1" <?= $user->role ? 'checked' : '' ?>>
		</label>
		<input type="submit" value="Подтвердить">
	</form>
</div>

<div>
	<form method="post">
		<input type="hidden" name="action" value="delete">
		<input type="submit" value="Удалить пользователя">
	</form>
</div>
