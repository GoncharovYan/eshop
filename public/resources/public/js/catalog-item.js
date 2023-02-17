export class CatalogItem
{
    id;
    title;
    shortDesc;
    price;
    imagePath;

    constructor({id, title, shortDesc, price, imagePath})
    {
        this.id = Number(id);
        this.title = String(title);
        this.shortDesc = String(shortDesc);
        this.price = Number(price);
        this.imagePath = String(imagePath);
    }

    render()
    {
        const row = document.createElement('div');
        row.classList.add('item');

        const imageColumn = document.createElement('img');
        imageColumn.setAttribute("src",  this.imagePath);

        const titleColumn = document.createElement('p');
        titleColumn.classList.add('name');

        const hrefColumn = document.createElement('a');
        hrefColumn.setAttribute("href",  "/product/"+this.id+"/");
        hrefColumn.innerText = this.title;

        titleColumn.append(hrefColumn);

        const shortDescColumn = document.createElement('span');
        shortDescColumn.classList.add();
        shortDescColumn.innerText = this.shortDesc;

        const priceColumn = document.createElement('p');
        priceColumn.classList.add('price');
        priceColumn.innerText = this.price+" ₽";

        row.append(imageColumn, titleColumn, shortDescColumn, priceColumn);
        return row;
    }
}