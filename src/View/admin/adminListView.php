<?php
/**
 * @var array $contentTable
 * @var array $contentTableHead
 * @var array $contentType
 */
?>

<script src="/resources/admin/js/admin-list.js"></script>

<div class="container">
	<table class="table table-sort table-striped ">
		<thead>
			<tr>
				<? foreach ($contentTableHead as $contentHead) {?>
					<th style="cursor: pointer"><?=$contentHead?></th>
				<?}?>
				<th>
					<a href="/admin/<?=$contentType?>/new/" class="btn btn-primary">Добавить</a>
				</th>
			</tr>
		</thead>
		<tbody class="elastic">
		<? foreach ($contentTable as $contentRow) {?>
			<tr>
				<? foreach ($contentRow as $content) {?>
					<th><?=$content ?></th>
				<?}?>
				<th>
					<a href="/admin/<?=$contentType?>/<?echo $contentRow['id']?>/" class="btn btn-secondary">Изменить</a>
				</th>
			</tr>
		<?}?>
		</tbody>
	</table>
</div>