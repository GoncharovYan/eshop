
export class PageList
{
    attachToNodeId = ''
    itemsContainer
    rootNode
    curPage
    maxPage
    search = ''


    constructor(attachToNodeId = '', curPage, maxPage, search ='',catalogList)
    {
        if(attachToNodeId === '')
        {
            throw new Error('attachToNodeId must be a filled string');
        }
        this.attachToNodeId = attachToNodeId;
        const rootNode = document.getElementById(attachToNodeId);
        if(!rootNode)
        {
            throw new Error()
        }

        this.rootNode = rootNode;

        if(search !== '')
        {
            this.search = '?search=' + search;
        }

        if (typeof updateButtonHandler === 'function')
        {
            this.updateButtonHandler = updateButtonHandler
        }
        this.curPage = curPage;
        this.maxPage = maxPage;


        this.catalogList = catalogList;


        this.creatItemsContainer()

    }

    creatItemsContainer()
    {
        this.rootNode.innerHTML = ''
        this.itemsContainer = document.createElement('div');
        this.itemsContainer.classList.add('pages-list');
        this.rootNode.append(this.itemsContainer);
    }

    render()
    {
        this.itemsContainer.innerHTML = ''

        if(this.curPage !== 1)
        {
            let firstPage = document.createElement('a')
            firstPage.classList.add('page')
            firstPage.addEventListener('click', ()=>this.swapPage(1))
            firstPage.innerText = '<<'
            this.itemsContainer.append(firstPage)
        }

        let firstPage;
        if( this.curPage - 3 < 1)
        {
            firstPage = 1
        }
        else
        {
            firstPage = this.curPage - 3
        }

        let lastPage;
        if( this.curPage + 3 > this.maxPage)
        {
            lastPage = this.maxPage
        }
        else
        {
            lastPage = this.curPage + 3
        }

        for (let i = firstPage; i <= lastPage; i++)
        {
            let pageButton = document.createElement('a')
            if(i != this.curPage)
            {
                pageButton.classList.add('page')
                pageButton.addEventListener('click', ()=>this.swapPage(i))
            }
            else
            {
                pageButton.classList.add('no-page')
            }
            pageButton.innerText = i.toString()
            this.itemsContainer.append(pageButton)
        }

        if(this.curPage !== this.maxPage)
        {
            let lastPage = document.createElement('a')
            lastPage.classList.add('page')
            lastPage.addEventListener('click', ()=>this.swapPage(this.maxPage))
            lastPage.innerText ='>>'
            this.itemsContainer.append(lastPage)
        }

    }
    swapPage(nextPage)
    {
        let strGET = window.location.search
        let url = "../"+nextPage+"/"+strGET
        window.history.pushState({},'',url)
        this.curPage = nextPage
        if (this.updateButtonHandler)
        {
            this.updateButtonHandler(this)
        }
        this.render()
        this.catalogList.swapPage()
    }
}
