(function () {
    const horas= document.querySelector('#horas');
    
    if(horas) {
        let busqueda = {
            categoria_id : '',
            dia: ''
        }

        //Recuperamos la categoria y el dia seleccionado por el usuario
        const dias= document.querySelectorAll('[name="dia"]');
        const categoria= document.querySelector('[name="categoria_id"]');
        const inputHiddenDia= document.querySelector('[name="dia_id"]');
        const inputHiddenHora= document.querySelector('[name="hora_id"]');

        dias.forEach(dia => {
            dia.addEventListener('change',terminoBusqueda);
        });
        categoria.addEventListener('change',terminoBusqueda);

        function terminoBusqueda(e) {
            //Vinculamos los datos al objeto busqueda
            busqueda[e.target.name] =e.target.value

            //Reiniciar campos ocultos y selector de horas
            inputHiddenHora.value= '';
            inputHiddenDia.value= '';
            
            const horaPrevia= document.querySelector('.horas__hora--selected');
            if (horaPrevia) {
                horaPrevia.classList.remove('horas__hora--selected');
            }


            if(Object.values(busqueda).includes('')){
                return ;
            }
            
            buscarEventos();
        }
        
        async function buscarEventos(){

            const { dia, categoria_id } = busqueda;

            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`; 

            const resultado= await fetch(url);
            const eventos = await resultado.json();

            console.log(eventos);
            obtenerHorasDisponibles(eventos);

        }

        function obtenerHorasDisponibles (eventos) {
            //Reiniciar las horas 
            const listadoHoras = document.querySelectorAll('#horas li');
            listadoHoras.forEach(li => {
                li.classList.add('horas__hora--deshabilitada');
                li.classList.remove('horas__hora--habilitada');
            });
            //Debemos eliminar el eventlistener de las deshabilitadas para que no se puedan seleccionar
            const horasDeshabilitadas = document.querySelectorAll('#horas li');
            horasDeshabilitadas.forEach( hora => hora.removeEventListener('click', seleccionarHora));


            //comprobar eventos y quitar deshabilitar
            const horasTomadas= eventos.map(evento => evento.hora_id);

            const listadoHorasArray= Array.from(listadoHoras);

            //Se filtran las horas que no se encuentran en horas tomadas
            const resultado = listadoHorasArray.filter(li => !horasTomadas.includes(li.dataset.horaId));
            resultado.forEach(li => {
                li.classList.remove('horas__hora--deshabilitada');
                li.classList.add('horas__hora--habilitada');

            });

            //Recupera las horas que no estan deshabilitadas
            const horasDisponibles= document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');

            horasDisponibles.forEach( hora => hora.addEventListener('click', seleccionarHora));
        }

        function seleccionarHora(e) {
            //deshabilita hora previo si nuevo click
            const horaPrevia= document.querySelector('.horas__hora--selected');
            if (horaPrevia) {
                horaPrevia.classList.remove('horas__hora--selected');
            }

            //agregar clase seleccionado
            e.target.classList.add('horas__hora--selected');

            //se añade el id de la hora al campo oculto de hora
            inputHiddenHora.value = e.target.dataset.horaId;
            
            
            //Llenar campo oculto de dia

            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
            inputHiddenDia.value = e.target.dataset.horaId;

        }
    }


})();