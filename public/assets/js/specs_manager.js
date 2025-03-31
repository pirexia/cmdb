$(document).ready(function() {
    $('#tipo_objeto').change(function() {
        const tipoObjeto = $(this).val();
        $('#specs-container').empty();
        
        if (tipoObjeto) {
            $.get(`/api/caracteristicas?tipo=${tipoObjeto}`, function(specs) {
                const template = $('#spec-template').html();
                
                specs.forEach(spec => {
                    let inputType = 'text';
                    let stepAttr = '';
                    
                    if (spec.tipo_dato === 'numero') inputType = 'number';
                    if (spec.tipo_dato === 'decimal') {
                        inputType = 'number';
                        stepAttr = 'step="0.01"';
                    }
                    
                    const specHtml = template
                        .replace(/{id}/g, spec.id)
                        .replace(/{nombre}/g, spec.nombre)
                        .replace(/{input_type}/g, inputType)
                        .replace(/{required}/g, spec.es_obligatorio ? 'required' : '')
                        .replace(/{step}/g, stepAttr)
                        .replace(/{unidad_html}/g, spec.unidad ? 
                            `<span class="input-group-text">${spec.unidad}</span>` : '');
                    
                    $('#specs-container').append(specHtml);
                });
            });
        }
    });
    
    if ($('#tipo_objeto').val()) {
        $('#tipo_objeto').trigger('change');
    }
});