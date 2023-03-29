$( document ).ready(function() {
  const generationId = $('#selectGenerations').val()
  const primaryTypeId = $('#selectPrimaryType').val()
  const secondaryTypeId = $('#selectSecondaryType').val()
  const orderBy = $('#selectOrderBy').val()

  pokemonList(generationId, primaryTypeId, secondaryTypeId, orderBy, 1)

  $.get( `api/generation_select.php`, e => {
    const generationList = $.parseJSON(e)
    const generationtHTML = []
    generationtHTML.push('<option value="">Selecione</option>')
    $( generationList.data ).each(function() {
      generationtHTML.push(`<option value="${this.generation_id}">${this.generation_name}</option>`)
    })
    $('#selectGenerations').empty().html(generationtHTML.join(''))

    $(`#selectGenerations option[value="${generationId}"]`).prop('selected', true);
  })

  primaryTypeList(generationId, secondaryTypeId)
  secondaryTypeList(generationId, primaryTypeId)

  $(`#selectOrderBy option[value="${orderBy}"]`).prop('selected', true);
});
