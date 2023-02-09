<?php
/**
 * @var array $contentTable
 * @var array $contentTableHead
 * @var array $contentType
 */
?>

<script>
	// Скрипт сортировки
	document.addEventListener('DOMContentLoaded', () => {
		const getSort = ({ target }) => {
			const order = (target.dataset.order = -(target.dataset.order || -1));
			const index = [...target.parentNode.cells].indexOf(target);
			const collator = new Intl.Collator(['en', 'ru'], { numeric: true });
			const comparator = (index, order) => (a, b) => order * collator.compare(
				a.children[index].innerHTML,
				b.children[index].innerHTML
			);
			for(const tBody of target.closest('table').tBodies)
				tBody.append(...[...tBody.rows].sort(comparator(index, order)));
			for(const cell of target.parentNode.cells)
				cell.classList.toggle('sorted', cell === target);
		};
		document.querySelectorAll('.table_sort thead').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));
	});
</script>

<div>
	<table class="table_sort">
		<thead>
			<tr>
				<? foreach ($contentTableHead as $contentHead) {?>
					<th><?=$contentHead?></th>
				<?}?>
				<th>
					<a href="/admin/<?=$contentType?>/new/">Добавить</a>
				</th>
			</tr>
		</thead>
		<tbody>
		<? foreach ($contentTable as $contentRow) {?>
			<tr>
				<? foreach ($contentRow as $content) {?>
					<th><?=$content ?></th>
				<?}?>
				<th>
					<a href="/admin/<?=$contentType?>/<?echo $contentRow['id']?>/">Изменить</a>
				</th>
			</tr>
		<?}?>
		</tbody>
	</table>
</div>

