$('#selectGenerations').change(function() {
  const generationId = $(this).val()
  const primaryTypeId = $('#selectPrimaryType').val()
  const secondaryTypeId = $('#selectPrimaryType').val()
  const orderBy = $('#selectOrderBy').val()

  pokemonList(generationId, primaryTypeId, secondaryTypeId, orderBy, 1)
  primaryTypeList(generationId, 0)
  secondaryTypeList(generationId, primaryTypeId)
})

$('#selectPrimaryType').change(function() {
  const generationId = $('#selectGenerations').val()
  const primaryTypeId = $(this).val()
  const secondaryTypeId = $('#selectSecondaryType').val()
  const orderBy = $('#selectOrderBy').val()

  pokemonList(generationId, primaryTypeId, secondaryTypeId, orderBy, 1)
  if (secondaryTypeId == '' || secondaryTypeId == null) {
    secondaryTypeList(generationId, primaryTypeId)
  }
})

$('#selectSecondaryType').change(function() {
  const generationId = $('#selectGenerations').val()
  const primaryTypeId = $('#selectPrimaryType').val()
  const secondaryTypeId = $(this).val()
  const orderBy = $('#selectOrderBy').val()

  pokemonList(generationId, primaryTypeId, secondaryTypeId, orderBy, 1)

  if (primaryTypeId == '') {
    primaryTypeList(generationId, secondaryTypeId)
  }
})

$('#selectOrderBy').change(function() {
  const generationId = $('#selectGenerations').val()
  const primaryTypeId = $('#selectPrimaryType').val()
  const secondaryTypeId = $('#selectSecondaryType').val()
  const orderBy = $(this).val()

  pokemonList(generationId, primaryTypeId, secondaryTypeId, orderBy, 1)
})
