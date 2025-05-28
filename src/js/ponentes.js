(function(){
    const ponentesInput = document.querySelector('#ponentes');

    if(ponentesInput){
        let ponentes = [];
        let ponentesFiltrados= [];

        const listadoPonentes= document.querySelector('#listado-ponentes');
        const ponenteHidden= document.querySelector('[name="ponente_id"]');

        obtenerPonentes();
        
        ponentesInput.addEventListener('input', buscarPonentes);

        if(ponenteHidden.value){
            (async() => {
                const ponente= await obtenerPonente(ponenteHidden.value);

                //Insertar en el HTML
                const ponenteDOM= document.createElement('LI');
                ponenteDOM.classList.add('listado-ponentes__ponente', 'listado-ponentes__ponente--selected');
                ponenteDOM.textContent= `${ponente.nombre} ${ponente.apellido}`;

                listadoPonentes.appendChild(ponenteDOM);
            })();
        }

        async function obtenerPonente(id){
            const url=`/api/ponente?id=${id}`;

            const respuesta= await fetch(url);
            const resultado = await respuesta.json();
            return resultado;
        }

        async function obtenerPonentes(){
            //Se obtienen los registros y se hace la busqueda contra el objeto en memoria
            const url = `/api/ponentes`; 

            const respuesta= await fetch(url);
            const resultado = await respuesta.json();
            formatearPonentes(resultado);
        }

        function formatearPonentes(arrayPonentes = []){
            ponentes= arrayPonentes.map(ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            });
        }

        function buscarPonentes(e){
            const busqueda = e.target.value;

            if(busqueda.length>=3){
                //Empezar a mostrar resultados a partir de letra 3

                //Buscamos por minuesculas, usando la siguiente expresion regular. Con el normalize y replace quitamos la tilde
                const expresionReg= new RegExp(busqueda.normalize('NFD').replace(/[\u0300-\u036f]/g, ""), "i")

                ponentesFiltrados = ponentes.filter (ponente => {
                    if(ponente.nombre.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase().search(expresionReg) != -1) { //si encuentra el ponente
                        return ponente;    
                    }
                });
            } else {
                //Se limpia si hay menos de 3 letras
                ponentesFiltrados = [];
            }
            mostrarPonentes();
        }

        function mostrarPonentes(){
            //Limpiar registros buscados previos
            while (listadoPonentes.firstChild) {
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            } 
            if(ponentesFiltrados.length > 0){
                //generar lista de filtrado
                ponentesFiltrados.forEach( ponente => {
                    const ponenteHTML= document.createElement('LI');
                    ponenteHTML.classList.add('listado-ponentes__ponente');
                    ponenteHTML.textContent= ponente.nombre;
                    ponenteHTML.dataset.ponenteId = ponente.id;

                    ponenteHTML.onclick= seleccionarPonente;
                    //Añadir al DOM
                    listadoPonentes.appendChild(ponenteHTML);
                });
            }else{
                //Mostrar mensaje no resultados
                const noResultados= document.createElement('P');
                noResultados.classList.add('listado-ponentes__no-resultado');
                noResultados.textContent= 'No hay resultados para esta búsqueda';
                if(ponentesInput.value.length >=3){

                    listadoPonentes.appendChild(noResultados);
                }
            }
            
        }


        function seleccionarPonente(e){
            const ponente= e.target;
            //eliminar seleccionado previo
            const ponentePrevio = document.querySelector('.listado-ponentes__ponente--selected');
            if(ponentePrevio){
                ponentePrevio.classList.remove('listado-ponentes__ponente--selected');
            }
            
            ponente.classList.add('listado-ponentes__ponente--selected');

            ponenteHidden.value= ponente.dataset.ponenteId;
        }
    }
})();