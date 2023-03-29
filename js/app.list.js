const pokemonList = (generationId, primaryTypeId, secondaryTypeId, orderBy, currentPage) => {
  const info = {
    generation_id: generationId,
    primary_type_id: primaryTypeId,
    secondary_type_id: secondaryTypeId,
    order_by: orderBy,
    page: currentPage,
  }

  $.post( `api/pokemon_list.php`, info, e => {
    const list = $.parseJSON(e)
    const html = []

    let qtd_total = list.qtd.total

    $('#totais').empty().html(`<p>Exibindo ${currentPage === 1 ? (qtd_total <= 30 ? qtd_total : 30) : currentPage * 30} de ${qtd_total} pokemons</p>`)

    Object.values(list.data).forEach(info => {
      let typeList = []
      typeList[0] = primaryTagHTML(info.primary_type.id, info.primary_type.name.english, info.primary_type.name.portuguese)
      if (info.secondary_type.id != null) {
        typeList[1] = secondaryTagHTML(info.secondary_type.id, info.secondary_type.name.english, info.secondary_type.name.portuguese)
      }

      let ability_list = []
      let ability_list_qtd = 'habilidade: '.length
      $.each(info.ability, function() {
        ability_list.push(`<a href="#"><span class="badge rounded-pill bg-secondary">${this}</span></a>`)
        ability_list_qtd += this.length
      });

      html.push(`
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <p class="text-center"><img class="imagem ${info.color}" alt="${info.name}" src="${info.image}"></p>
                </div>
                <div class="col-12">
                  <p class="card-text">
                    <strong># ${formatNumber(info.id)} - ${info.name}</strong><br>
                    <strong>Geração ${info.generation}</strong><br>
                    ${typeList.join(' | ')}
                  </p>
                </div>
                <div class="col-md-12">
                  <p></p>
                  <p class="text-center">
                    <a type="button" class="btn btn-outline-dark btn-lg btn-block btn-sm" href="pokemon.html?pokemon_id=${info.id}">+Informações</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      `)
    });

    $('#pokedex').empty().html(html.join(''))

    pagination(list.qtd.total, currentPage)
  })
}

const primaryTypeList = (generationId, secondaryTypeId) => {
  let primarySelectParams = []
  if (generationId != null && generationId != '') {
    primarySelectParams.push(`generation_id=${generationId}`)
  }

  if (secondaryTypeId != null && secondaryTypeId != '') {
    primarySelectParams.push(`secondary_type_id=${secondaryTypeId}`)
  }

  $.get( `api/primary_select.php?${primarySelectParams.join('&')}`, e => {
    const typeList = $.parseJSON(e)
    const primaryTypeHTML = []

    primaryTypeHTML.push('<option value="">Selecione</option>')
    Object.values( typeList.data ).forEach(info => {
      primaryTypeHTML.push(optionHTML(info.id, info.portuguese_name, info.qtd))
    })
    $('#selectPrimaryType').empty().html(primaryTypeHTML.join(''))
  })
}

const secondaryTypeList = (generationId, primaryTypeId) => {
  let secondarySelectParams = []

  if (generationId != null) {
    secondarySelectParams.push(`generation_id=${generationId}`)
  }

  if (primaryTypeId != null){
    secondarySelectParams.push(`primary_type_id=${primaryTypeId}`)
  }

  $.get( `api/secondary_select.php?${secondarySelectParams.join('&')}`, e => {
    const typeList = $.parseJSON(e)
    const secondarySelectHTML = []

    secondarySelectHTML.push('<option value="">Selecione</option>')
    Object.values( typeList.data ).forEach(info => {
      secondarySelectHTML.push(optionHTML(info.id, info.portuguese_name, info.qtd))
    })
    $('#selectSecondaryType').empty().html(secondarySelectHTML.join(''))
  })
}
