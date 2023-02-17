import {CatalogItem} from "./catalog-item.js";

export class CatalogList
{
    attachToNodeId = '';
    itemsContainer;
    rootNode;
    items = [];

    constructor({attachToNodeId = '', items = []})
    {
        if(attachToNodeId === '')
        {
            throw new Error('attachToNodeId must be a filled string');
        }

        const rootNode = document.getElementById(attachToNodeId);
        if(!rootNode)
        {
            throw new Error()
        }

        this.rootNode = rootNode;

        this.items = items.map((item)=>{
            return this.createItem(item);
        })

        this.creatItemsContainer()
    }

    creatItemsContainer()
    {
        this.itemsContainer = document.createElement('div')
        this.itemsContainer.classList.add('catalog-list')

        this.rootNode.append(this.itemsContainer)
    }

    createItem(itemData)
    {
        return new CatalogItem(itemData)
    }

    render()
    {
        this.itemsContainer.innerHTML = ''
        this.items.forEach((item)=>{
            this.itemsContainer.append(item.render())
        })
    }

    swapPage()
    {
        let url = window.location.href.split('?')[0]+"change/" + window.location.search;
        fetch(url)
            .then((response) =>
                response.json()
            )
            .then((data)=>
                {

                    this.items = data[0].map((item)=>{
                        return this.createItem(item);
                    })
                    this.render()
                }
            )
    }
}
