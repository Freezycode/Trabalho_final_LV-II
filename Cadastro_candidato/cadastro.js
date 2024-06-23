function handleTypeChange(value) {
    var curriculoField = document.getElementById('curriculoField');
    var descricaoField = document.getElementById('descricaoField');
    if (value === 'Candidato') {
        curriculoField.style.display = 'block';
        descricaoField.style.display = 'block';
    } else {
        curriculoField.style.display = 'none';
        descricaoField.style.display = 'none';
    }
}