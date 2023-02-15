import {CatalogItem} from "./catalog-item.js";

export class CatalogList
{
    attachToNodeId = '';
    items = [];
    rootNode;

    constructor({attachToNodeId, items})
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

        this.items = items.map((itemData)=>{
            return this.createItem(itemData);
        })

    }

    createItem(itemData)
    {
        return new CatalogItem(itemData)
    }

    render()
    {

    }
}