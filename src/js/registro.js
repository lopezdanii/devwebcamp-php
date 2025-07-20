import Swal from 'sweetalert2';

(function(){
    let eventos= [];

    const resumen= document.querySelector('#registro-resumen');
    if(resumen){
        
        const eventosBoton= document.querySelectorAll('.evento__agregar');
        
        eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento ));
        
        const formularioRegistro = document.querySelector('#registro');
        formularioRegistro.addEventListener('submit', submitFormulario);
        
        mostrarEventos();

        /**
         * Función para seleccionar los eventos a los que el usuario da click para escogerlos
         * @param {*} e evento de click
        */
        function seleccionarEvento(e){
           if(eventos.length < 5 ){
               
               eventos= [...eventos, {
                id: e.target.dataset.id,
                titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim() //se recupera el titulo del elemento superior
            }]
            
            //Deshabilitar el evento una vez añadido, para que no se incluya en el array repetido
            e.target.disabled=true;
            mostrarEventos();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Máximo 5 eventos por registro',
                    icon: 'error',
                    confirmButtonTest: 'OK'
                });
            }
        }
    
    
        /**
         * Funcion para mostrar los eventos escogidos en el aside derecho de Registro
        */
        function mostrarEventos(){
            //limpiar el hmtl primero para no mostrar el array varias veces
            limpiarEventos();
            
            
            if(eventos.length > 0 ){
                eventos.forEach(evento => {
                    const eventoDOM= document.createElement('DIV');
                    eventoDOM.classList.add('registro__evento');
                    
                    const titulo= document.createElement('H3');
                    titulo.classList.add('registro__nombre');
                    titulo.textContent = evento.titulo;
                    
                    //Se añade boton de eliminar evento de la lista de seleccionados
                    const botonEliminar= document.createElement('BUTTON');
                    botonEliminar.classList.add('registro__eliminar');
                    botonEliminar.innerHTML=`<i class="fa-solid fa-trash"></i>`;
                    botonEliminar.onclick = function(){
                        eliminarEvento(evento.id);
                    }
                        
                        //Renderizar en el html
                        eventoDOM.appendChild(titulo);
                        eventoDOM.appendChild(botonEliminar);
                        resumen.appendChild(eventoDOM);
                    })
            }else {
                const noRegistro= document.createElement('P');
                noRegistro.textContent = 'No hay eventos, añade hasta 5 eventos como máximo';
                noRegistro.classList.add('registro__texto');
                resumen.appendChild(noRegistro);
            }
        }

            /**
             * Se limpian el resumen que contiene array de eventos seleccionados
            */
        function limpiarEventos(){
            while(resumen.firstChild){
                resumen.removeChild(resumen.firstChild);
                }
            }
            
            
            /**
             * Elimina el evento al que se le ha seleccionado el icono de papelera
             * @param {*} id Identificador del evento
            */
        function eliminarEvento(id){
            eventos = eventos.filter(evento => evento.id !== id);
            
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled=false;
            mostrarEventos();
        }

        async function submitFormulario(e){
            e.preventDefault();

            //Obtener el regalo
            const regaloId= document.querySelector('#regalo').value;

            const eventosId= eventos.map(evento => evento.id);

            if(eventosId.length === 0 || regaloId ===''){
                Swal.fire({
                    title: 'Error',
                    text: 'Elige al menos un evento y un regalo',
                    icon: 'error',
                    confirmButtonTest: 'OK'
                });
                return;
            }

            //Objeto de Form Data
            const datos= new FormData();
            datos.append('eventos', eventosId);
            datos.append('regalo_id', regaloId);

            const url= '/finalizar-registro/conferencias';
            const respuesta= await fetch(url , {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            console.log(resultado);

            if(resultado.resultado){
                Swal.fire(
                    'Registrado correctamente',
                    'Tus conferencias se han almacenado. Te esperamos en DevWebCamp',
                    'success'
                ).then( () => location.href= `/boleto?id=${resultado.token}`);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un error al registrar, comprueba el número de plazas otra vez',
                    icon: 'error',
                    confirmButtonTest: 'OK'
                }).then( () => location.reload());
            }
        }
    }
})();