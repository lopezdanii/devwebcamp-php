<h2 class="dashboard__heading"><?php echo $titulo ;?></h2>


<main class="bloques">
    <div class="bloques__grid">
        <div class="bloque">
            <h3 class="bloque__heading"> Últimos registros</h3>
            
            <?php foreach($registros as $registro){ ?>
                    <div class="bloque__contenido">
                        <p class="bloque__texto">
                            <?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido;?>
                        </p>
                    </div>
                <?php } ?>

        </div>

        <div class="bloque">
            <h3 class="bloque__heading"> Ingresos</h3>
                <div class="bloque__contenido">
                    <p class="bloque__texto--cantidad">
                        <?php echo $ingresos . "€";?>
                    </p>
                </div>
        </div>

        <div class="bloque">
            <h3 class="bloque__heading"> Eventos con menos plazas disponibles</h3>
            
            <div class="bloque__contenido">
                <?php foreach ($eventos_menos_disponibles as $evento) { ?>
                    <p class="bloque__texto">
                        <?php echo $evento->nombre . " - " . $evento->disponibles . " disponibles";?>
                    </p>
                <?php   } ?>
            </div>
        </div>

        <div class="bloque">
            <h3 class="bloque__heading"> Eventos con más plazas disponibles</h3>
            
            <div class="bloque__contenido">
                <?php foreach ($eventos_mas_disponibles as $evento) { ?>
                    <p class="bloque__texto">
                        <?php echo $evento->nombre . " - " . $evento->disponibles . " disponibles";?>
                    </p>
                <?php   } ?>
            </div>
        </div>

</main>