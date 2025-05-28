(function () {
    const horas = document.querySelector("#horas");
    let horaSeleccionada;
    let radioSeleccionado;
    let optionSeleccionado;
 
    if (horas) {
        const categoria = document.querySelector("[name='categoria_id']");
        const dias = document.querySelectorAll("[name='dia']");
        const inputHiddenDia = document.querySelector("[name='dia_id']");
        const inputHiddenHora = document.querySelector("[name='hora_id']");
 
        categoria.addEventListener("change", terminoBusqueda);
        dias.forEach((dia) => dia.addEventListener("change", terminoBusqueda));
 
        let busqueda = {
            categoria_id: +categoria.value || "",
            dia: +inputHiddenDia.value || "",
        };
 
        if (!Object.values(busqueda).includes("")) {
            (async () => {
                await buscarEventos();
 
                const id = inputHiddenHora.value;
 
                // Aqui asignamos el valor a la variable global porque lo requeriremos despues
                horaSeleccionada = document.querySelector(
                    `[data-hora-id='${id}']`
                );
 
                // Guardamos el valor del select y el valor del radio activo
                radioSeleccionado = document.querySelector(
                    '[name="dia"]:checked'
                );
                optionSeleccionado = document.querySelector(
                    '[name="categoria_id"]'
                ).value;
 
                horaSeleccionada.classList.remove("horas__hora--deshabilitada");
                horaSeleccionada.classList.add("horas__hora--seleccionada");
 
                horaSeleccionada.onclick = seleccionarHora;
            })();
        }
 
        function terminoBusqueda(e) {
            busqueda[e.target.name] = e.target.value;
 
            // Reiniciar los campos ocultos y el selector de horas
            inputHiddenHora.value = "";
            inputHiddenDia.value = "";
 
            const horaPrevia = document.querySelector(
                ".horas__hora--seleccionada"
            );
            if (horaPrevia) {
                horaPrevia.classList.remove("horas__hora--seleccionada");
            }
 
            if (Object.values(busqueda).includes("")) {
                return;
            }
            buscarEventos();
        }
 
        async function buscarEventos() {
            const { dia, categoria_id } = busqueda;
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;
 
            const resultado = await fetch(url);
            const eventos = await resultado.json();
 
            obtenerHorasDisponibles(eventos);
        }
 
        function obtenerHorasDisponibles(eventos) {
            // Reiniciar las horas
            const listadoHoras = document.querySelectorAll("#horas li");
            listadoHoras.forEach((li) =>
                li.classList.add("horas__hora--deshabilitada")
            );
 
            // Comprobar eventos ya tomados y quitar el deshabilidado
            const horasTomadas = eventos.map((evento) => evento.hora_id);
 
            const listadoHorasArray = Array.from(listadoHoras);
            const resultado = listadoHorasArray.filter(
                (li) => !horasTomadas.includes(li.dataset.horaId)
            );
 
            resultado.forEach((li) =>
                li.classList.remove("horas__hora--deshabilitada")
            );
 
            // Obtener todos los li y añadir un Event Listener
            const horasDisponibles = document.querySelectorAll("#horas li");
            horasDisponibles.forEach((hora) => {
                hora.addEventListener("click", seleccionarHora);
            });
 
            // Obtener el li con la clase buscada y eliminar el Event listener para que no se pueda seleccionar
            const horasDeshabilitadas = document.querySelectorAll(
                ".horas__hora--deshabilitada"
            );
            horasDeshabilitadas.forEach((hora) =>
                hora.removeEventListener("click", seleccionarHora)
            );
 
            if (
                horaSeleccionada &&
                optionSeleccionado === document.querySelector("select").value &&
                radioSeleccionado ===
                    document.querySelector('[name="dia"]:checked')
            ) {
                // Eliminamos la clase deshabilitada
                horaSeleccionada.classList.remove("horas__hora--deshabilitada");
                // Añadimos la clase para verla como seleccionada
                horaSeleccionada.classList.add("horas__hora--seleccionada");
 
                // Volvemos a llenar los campos hidden
                inputHiddenHora.value = horaSeleccionada.dataset.horaId;
                inputHiddenDia.value = optionSeleccionado;
            }
        } // Cierre de la función obtenerHorasDisponibles
 
        function seleccionarHora(e) {
            const horaPrevia = document.querySelector(
                ".horas__hora--seleccionada"
            );
            if (horaPrevia) {
                horaPrevia.classList.remove("horas__hora--seleccionada");
            }
 
            e.target.classList.add("horas__hora--seleccionada");
 
            inputHiddenHora.value = e.target.dataset.horaId;
            inputHiddenDia.value = document.querySelector(
                "[name='dia']:checked"
            ).value;
        }
    }
})();