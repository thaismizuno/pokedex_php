const pagination = (qtdTotal, currentPage) => {
  const lastPage = Math.ceil(qtdTotal/30) - 1

  if (lastPage == 0 || lastPage == 1) {
    $('#pagination').empty().html(`<ul class="pagination justify-content-center"></ul>`);
    return false
  }

  const htmlFirstPrevious = `
    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
      <a class="page-link" href="javascript:goToPage(1)" aria-label="Primeiro">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Primeiro</span>
      </a>
    </li>
    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
      <a class="page-link" href="javascript:goToPage(${currentPage-1})" aria-label="Anterior">
        <span aria-hidden="true">&#8249;</span>
        <span class="sr-only">Anterior</span>
      </a>
    </li>`

    let htmlPages = ''
    if (currentPage == 1 || currentPage == 2 || currentPage == 3) {
      for (let i = 1; i <= (lastPage > 5 ? 5 : lastPage); i++) {
        htmlPages += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="javascript:goToPage(${i})">${i}</a></li>`
      }
    } else {
      if (currentPage >= lastPage-2) {
        for (let i = (lastPage - 4); i <= lastPage; i++) {
          htmlPages += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="javascript:goToPage(${i})">${i}</a></li>`
        }
      } else {
        for (let i = (currentPage - 2); i <= (currentPage + 2); i++) {
          htmlPages += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="javascript:goToPage(${i})">${i}</a></li>`
        }
      }
    }

    const htmlNextLast = `<li class="page-item">
      <a class="page-link" href="javascript:goToPage(${currentPage+1})" aria-label="Último">
        <span class="sr-only">Próximo</span>
        <span aria-hidden="true">&#8250;</span>
      </a>
    </li>
    <li class="page-item">
      <a class="page-link" href="javascript:goToPage(${lastPage})" aria-label="Último">
        <span class="sr-only">Último</span>
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>`


  $('#pagination').empty().html(`<ul class="pagination justify-content-center">${htmlFirstPrevious}${htmlPages}${htmlNextLast}</ul>`);
}

const goToPage = (page) => {
  const generationId = $('#selectGenerations').val()
  const primaryTypeId = $('#selectPrimaryType').val()
  const secondaryTypeId = $('#selectSecondaryType').val()
  const orderBy = $('#selectOrderBy').val()

  pokemonList(generationId, primaryTypeId, secondaryTypeId, orderBy, page)
}
