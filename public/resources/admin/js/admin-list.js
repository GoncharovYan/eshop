// Сортировка.
document.querySelector('#elastic').oninput = function(){
	let val = this.value.trim();
	let elasticItems = document.querySelectorAll('.elastic tr');
	if (val !== ''){
		elasticItems.forEach(function (elem){
			if (elem.innerText.toLowerCase().search(val.toLowerCase()) === -1){
				elem.classList.add('hide');
			}
			else {
				elem.classList.remove('hide');
			}
		});
	}
	else {
		elasticItems.forEach(function (elem){
			elem.classList.remove('hide');
		});
	}
}

// Умный поиск.
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
	document.querySelectorAll('.table-sort thead').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));
});