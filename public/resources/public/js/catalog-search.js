
function searchItem()
{
  var search = document.getElementById('search-text').value
  if(search)
  {
    if(window.location.pathname.indexOf('/catalog/') === -1)
    {
      window.location.href = `/catalog/all/1/?search=${search}`
    }
    else
    {
      window.location.href = `../1/?search=${search}`
    }
  }
  else
  {
    window.alert("Отсутствует значение в строке поиска!")
  }
}