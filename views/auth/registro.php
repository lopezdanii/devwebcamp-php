<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Regístrate en DevWebCamp</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" method="POST" action="/registro">
        <div class="formulario__campo">
            <label class="formulario__label" for="nombre">Nombre</label>
            <input type="text" class="formulario__input" placeholder="Tu nombre" id="nombre" name="nombre" value="<?php echo $usuario->nombre; ?>">
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="apellido">Apellidos</label>
            <input type="text" class="formulario__input" placeholder="Tus apellidos" id="apellido" name="apellido" value="<?php echo $usuario->apellido; ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="email">Email</label>
            <input type="email" class="formulario__input" placeholder="Tu email" id="email" name="email" value="<?php echo $usuario->email; ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="password">Contraseña</label>
            <input type="password" class="formulario__input" placeholder="Tu contraseña" id="password" name="password">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="password2">Repetir Contraseña</label>
            <input type="password" class="formulario__input" placeholder="Repetir contraseña" id="password2" name="password2">
        </div>

        <input class="formulario__submit" type="submit" value="Crear cuenta">
    </form>

    <div class="acciones">
        <a class="acciones__enlace" href="/login">¿Ya tiene cuenta?  Iniciar sesión</a>
        <a class="acciones__enlace" href="/olvide">¿Olvidaste la contraseña? Resetear contraseña</a>
    </div>

</main>