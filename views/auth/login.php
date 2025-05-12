<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Inicia sesión en DevWebCamp</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" action="/login" method="POST">
        <div class="formulario__campo">
            <label class="formulario__label" for="email">Email</label>
            <input type="email" class="formulario__input" placeholder="Tu email" id="email" name="email">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="password">Contraseña</label>
            <input type="password" class="formulario__input" placeholder="Tu contraseña" id="password" name="password">
        </div>
        <input class="formulario__submit" type="submit" value="Iniciar sesión">
    </form>

    <div class="acciones">
        <a class="acciones__enlace" href="/registro">¿No tiene cuenta? Crear una</a>
        <a class="acciones__enlace" href="/olvide">¿Olvidaste la contraseña? Resetear contraseña</a>
    </div>

</main>