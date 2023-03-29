const filterPokemonByPrimaryId = (primaryTypeId) => {
  $(`#selectPrimaryType option[value=${primaryTypeId}]`).attr('selected','selected');

  const generationId = $('#selectGenerations').val()
  const secondaryTypeId = $('#selectSecondaryType').val()
  const orderBy = $('#selectOrderBy').val()

  pokemonList(generationId, primaryTypeId, secondaryTypeId, orderBy, 1)
  secondaryTypeList(generationId, primaryTypeId)
}

const filterPokemonBySecondaryId = (secondaryTypeId) => {
  $(`#selectSecondaryType option[value=${secondaryTypeId}]`).attr('selected','selected');

  const generationId = $('#selectGenerations').val()
  const primaryTypeId = $('#selectPrimaryType').val()
  const orderBy = $('#selectOrderBy').val()

  pokemonList(generationId, primaryTypeId, secondaryTypeId, orderBy, 1)
}