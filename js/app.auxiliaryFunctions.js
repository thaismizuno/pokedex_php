const formatNumber = number => {
  const count = number.toString().length;

  for (let i = count; i < 4; i++) {
    number = '0' + number.toString();
  }
  
  return number;
}

const optionHTML = (id, portuguese_name, qtd) => {
  return `<option value="${id}">${portuguese_name == null ? 'Sem Tipo Secundário' : portuguese_name} - ${qtd} ${(qtd == 1 ? 'Pokemon' : 'Pokemons')}</option>`
}

const primaryTagHTML = (typeId, englishName, portugueseName) => {
  return `<span class="badge rounded-pill type-${englishName}"><a href="javascript:filterPokemonByPrimaryId(${typeId})">${portugueseName}</a></span>`
}

const secondaryTagHTML = (typeId, englishName, portugueseName) => {
  return `<span class="badge rounded-pill type-${englishName}"><a href="javascript:filterPokemonBySecondaryId(${typeId})">${portugueseName}</a></span>`
}
