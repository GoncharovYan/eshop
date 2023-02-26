<?php
/**
 * @var User $user
 * @var int $token
 */

use Models\User;

?>

<div class="container d-flex flex-column shadow p-3 my-5 bg-white rounded">
	<div>
		<form method="post">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="token" value="<?= $token?>">

			<div class="form-group mb-2">
				<label class="form-label">Email</label>
				<input class="form-control" type="email" name="email" value="<?= $user->email ?>">
			</div>

			<div class="form-group mb-2">
				<label class="form-label">Логин</label>
				<input class="form-control" type="text" name="login" value="<?= $user->login ?>">
			</div>

			<div class="form-group mb-2">
				<label class="form-label">Новый пароль</label>
				<input class="form-control" type="password" name="password" value="">
			</div>

			<label class="d-flex p-3"">
			<div class="form-check">
				Админ
				<input type="radio" name="role" value="0" <?= $user->role ? '' : 'checked' ?>>
			</div>
			<div class="form-check">
				Пользователь
				<input type="radio" name="role" value="1" <?= $user->role ? 'checked' : '' ?>>
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
				<input type="hidden" name="token" value="<?= $token?>">
				<button type="submit" class="btn btn-danger">Удалить пользователя</button>
			</form>
		</div>
	</div>
</div>

