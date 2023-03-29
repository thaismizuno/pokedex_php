const clearPrimaryTypeInfo = () => {
  primaryTypeInfo = []

  translateTypes.forEach(typeInfo => {
    primaryTypeInfo.push({
      type: typeInfo.type,
      translate: typeInfo.translate,
      qtd: 0
    })
  })
}

const clearSecondaryTypeInfo = () => {
  secondaryTypeInfo = []

  translateTypes.forEach(typeInfo => {
    secondaryTypeInfo.push({
      type: typeInfo.type,
      translate: typeInfo.translate,
      qtd: 0
    })
  })
}

const findAndSetPrimaryTypeInfo = primaryTypeName => {
  let idPrimaryType = primaryTypeInfo.findIndex(info => info.type === primaryTypeName);
  primaryTypeInfo[idPrimaryType].qtd++;
}

const findAndSetSecondaryTypeInfo = secondaryTypeName => {
  let idSecondaryType = secondaryTypeInfo.findIndex(info => info.type === secondaryTypeName);
  secondaryTypeInfo[idSecondaryType].qtd++;
}