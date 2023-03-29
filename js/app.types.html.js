const typeHTML = infoFilter => {
  let html = []
  html.push(`<option value="">Selecione</option>`)
  infoFilter.forEach(info => {
    html.push(`<option value="${info.type}">${info.translate} - ${info.qtd} pokemons</option>`)
  })

  return html.join('')
}

const primaryTypeHTML = () => {
  let infoFilter = primaryTypeInfo.filter(info => info.qtd >= 1)
  getElementById('selectPrimaryType').innerHTML = typeHTML(infoFilter)

  return false
}

const secondaryTypeHTML = () => {
  let infoFilter = secondaryTypeInfo.filter(info => info.qtd >= 1)
  getElementById('selectSecondaryType').innerHTML = typeHTML(infoFilter)

  return false
}
