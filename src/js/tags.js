(function() {
    const tagsInput = document.querySelector('#tags_input');

    
    if(tagsInput) {
        const tagsDiv = document.querySelector('#tags');
        const tagsInputHidden = document.querySelector('[name="tags"]');
        let tags = [];

        // Recuperar del input oculto
        if(tagsInputHidden.value !== '') {
            tags = tagsInputHidden.value.split(',');
            mostrarTags();
        }
        //Escuchar los cambios en el input
        tagsInput.addEventListener('keypress', guardarTag);
        
        //Almacena en array tagsInput los valores que se escriban en el formulario separados por comas
        function guardarTag(e) {
            if(e.key ===','){
                e.preventDefault(); //Prevenir accion por defecto, que es escribir en el campo del formulario, no agrega la coma
                
                if(e.target.value.trim()=== '' || e.target.value<1){
                    return;
                }

                tags = [...tags, e.target.value.trim()];
                tagsInput.value= '';

                mostrarTags();
            }
        }
        
        //Muestra los tags almacenados en el formulario como lista
        function mostrarTags() {
            tagsDiv.textContent = '';

            tags.forEach(tag => {
                const etiqueta = document.createElement('LI');
                etiqueta.classList.add('formulario__tag');
                etiqueta.textContent = tag;
                etiqueta.ondblclick = eliminarTag;
                tagsDiv.appendChild(etiqueta);
            });
            actualizarInputHidden();
        }

        function eliminarTag(e){
            e.target.remove();
            tags = tags.filter(tag => tag !== e.target.textContent);
            actualizarInputHidden();
        }

        function actualizarInputHidden(){
            tagsInputHidden.value = tags.toString();
        }
    }

})()

