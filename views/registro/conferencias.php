
    <h2 class="pagina__heading"> <?php echo $titulo; ?></h2>
    <p class="pagina__descripcion">Elige hasta 5 eventos para asistir de forma presencial</p>

<div class="eventos-registro">
    
    <main class="eventos-registro__listado">
        <h3 class="eventos-registro__heading--conferencias">&lt; Conferencias /></h3>
        <p class="eventos-registro__fecha">Viernes 5 de Octubre</p>

        <div class="eventos-registro__grid">
            <?php foreach ($eventos['conferencias_v'] as $evento){ 
                    include __DIR__ . '/evento.php';
                } ?>
        </div>

        <p class="eventos-registro__fecha">Sábado 6 de Octubre</p>

        <div class="eventos-registro__grid">
            <?php foreach ($eventos['conferencias_s'] as $evento){ 
                    include __DIR__ . '/evento.php';
                } ?>
        </div>

        <h3 class="eventos-registro__heading--workshops">&lt; Workshops /></h3>
        <p class="eventos-registro__fecha">Viernes 5 de Octubre</p>

        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach ($eventos['workshops_v'] as $evento){ 
                    include __DIR__ . '/evento.php';
                } ?>
        </div>

        <p class="eventos-registro__fecha">Sábado 6 de Octubre</p>

        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach ($eventos['workshops_s'] as $evento){ 
                    include __DIR__ . '/evento.php';
                } ?>
        </div>

    </main>

    <aside class="registro">
        <h2 class="registro__heading" >Tu registro</h2>
        <div class="registro-resumen" id="registro-resumen"></div>

        <div class="registro__regalo">
            <label for="regalo" class="registro__label">Selecciona un regalo</label>
            <select  id="regalo" class="registro__select">
                <option value="" selected disabled >-- Selecciona tu regalo --</option>
                <?php foreach($regalos as $regalo) { ?>
                    <option value="<?php echo $regalo->id; ?>"><?php echo $regalo->nombre; ?></option>
                    
                <?php } ?>
            </select>
        </div>

        <form id="registro" class="formulario">
            <div class="formulario__campo">
                <input type="submit" class="formulario__submit formulario__submit--full" value="Registrarme">
            </div>
        </form>
    </aside>

</div>