<fieldset class="formulatio__fieldset">
    <legend class="formulario__legend">Información evento</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre"> Nombre evento </label>
        <input type="text" class="formulario__input"  id="nombre" name="nombre" placeholder = "Nombre Evento" value="<?php echo $evento->nombre;?>">

    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="descripcion"> Descripción evento </label>
        <textarea  class="formulario__input"  id="descripcion" name="descripcion" placeholder = "Descripción Evento" rows=8 ><?php echo $evento->descripcion;?></textarea>

    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="categoria"> Categoría </label>
        <select class="formulario__select" name="categoria_id" id="categoria">
            <option  selected disabled>--Seleccionar--</option>
            <?php foreach ($categorias as $categoria){ ?>
                <!--Si la categoria es la misma lo marcamos como seleccionado -->
                <option <?php echo ($evento->categoria_id === $categoria->id) ? 'selected' : '' ?>
                    value="<?php echo $categoria->id; ?>"> <?php echo $categoria->nombre;?></option>
            
            <?php } ?>
        </select>

    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="dia"> Selecciona el día </label>

            <div class="formulario__radio">
                <?php foreach ($dias as $dia) { ?>
                    <div>
                        <label for="<?php echo strtolower($dia->nombre)?>"><?php echo $dia->nombre; ?></label>
                        <input type="radio" id="<?php echo strtolower($dia->nombre)?>" name="dia" value="<?php echo $dia->id?>">
                    
                    </div>
                
                <?php }?>
            </div>
            <input type="hidden" name="dia_id" value="">
    </div>

    <div id="horas" class="formulario__campo">
        <label class="formulario__label" for="hora"> Selecciona Hora </label>
            <ul id="horas" class="horas">
                <?php foreach($horas as $hora) { ?>
                    <li data-hora-id="<?php echo $hora->id;?>" class="horas__hora horas__hora--deshabilitada"><?php echo $hora->hora;?></li>
                <?php } ?>
            </ul>

            <input type="hidden" name="hora_id" value="">


    </div>


</fieldset>

<fieldset class="formulatio__fieldset">
    <legend class="formulario__legend">Información extra</legend>
        <div class="formulario__campo">
            <label class="formulario__label" for="ponentes"> Ponente </label>
            <input type="text" class="formulario__input"  id="ponentes"  placeholder = "Buscar ponente" >

        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="disponibles"> Lugares disponibles </label>
            <input type="number" class="formulario__input"  id="disponibles" name="disponibles" placeholder = "Ej: 20" min="1" value= "<?php echo $evento->disponibles;?>" >

        </div>

    </legend>
</fieldset>