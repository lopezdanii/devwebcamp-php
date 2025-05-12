<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Introduce tu nueva contraseña</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <?php if($token_valido) { ?>
        <form class="formulario" method="POST" >
            <div class="formulario__campo">
                <label class="formulario__label" for="password">Nueva contraseña</label>
                <input type="password" class="formulario__input" placeholder="Escribe una nueva contraseña" id="password" name="password" >
            </div>


            <input class="formulario__submit" type="submit" value="Guardar contraseña">
        </form>

    <?php } ?>

    <div class="acciones">
        <a class="acciones__enlace" href="/login">¿Ya tienes una cuenta? Iniciar sesión </a>
        <a class="acciones__enlace" href="/registro">¿No tienes una cuenta? Crear una </a>
    </div>

</main>