<fieldset class="formulatio__fieldset">
    <legend class="formulario__legend">Información evento</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre"> Nombre evento </label>
        <input type="text" class="formulario__input"  id="nombre" name="nombre" placeholder = "Nombre Evento" >

    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="descripcion"> Descripción evento </label>
        <textarea  class="formulario__input"  id="descripcion" name="descripcion" placeholder = "Descripción Evento" rows=8></textarea>

    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="categoria"> Categoría </label>
        <select class="formulario__select" name="" id="categoria">
            <option value="" selected disabled>--Seleccionar--</option>
            <?php foreach ($categorias as $categoria){ ?>
                <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre;?></option>
            
            <?php } ?>
        </select>
        <textarea  class="formulario__input"  id="descripcion" name="descripcion" placeholder = "Descripción Evento" rows=8></textarea>

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
    </div>

    <div id="horas" class="formulario__campo">
        <label class="formulario__label" for="hora"> Selecciona Hora </label>
            <ul class="horas">
                <?php foreach($horas as $hora) { ?>
                    <li class="horas__hora"><?php echo $hora->hora;?></li>
                <?php } ?>
            </ul>

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
            <input type="number" class="formulario__input"  id="disponibles"  placeholder = "Ej: 20" min=1 >

        </div>

    </legend>
</fieldset>