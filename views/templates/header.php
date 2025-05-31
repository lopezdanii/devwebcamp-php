<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if(is_auth()) {?>
                <a href="<?php echo is_admin() ? '/admin/dashboard' : '/finalizar-registro' ;?>" class="header__enlace">Administrar</a>

                <form class="header__form" action="/logout" method="POST">
                    <input class="header__submit--logout" type="submit" value="Cerrar Sesión">
                </form>
            <?php } else {?>
            <a href="/registro" class="header__enlace">Registro</a>
            <a href="/login" class="header__enlace">Iniciar sesión</a>
            <?php } ?>
        </nav>

        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">&#60DevWebCamp /></h1>
            </a>
            <p class="header__texto">Octubre 5-6-25 </p>
            <p class="header__texto header__texto--modalidad">En línea - Presencial </p>

            <a href="/registro" class="header__boton"> Comprar Pase</a>
        </div>
    </div>
</header>

<div class="barra">
    <div class="barra__contenido">
        <a href="/" > 
            <h1 class="barra__logo"> &#60DevWebCamp /></h1>
        </a>
        <nav class="navegacion"> 
            <a href="/devwebcamp" class="navegacion__enlace <?php echo pagina_actual('/devwebcamp') ? 'navegacion__enlace--actual' : ''?>">Eventos</a>
            <a href="/paquetes" class="navegacion__enlace <?php echo pagina_actual('/paquetes') ? 'navegacion__enlace--actual' : ''?>">Paquetes</a>
            <a href="/workshops-conferencias" class="navegacion__enlace <?php echo pagina_actual('/workshops-conferencias') ? 'navegacion__enlace--actual' : ''?>"> Workshops /Conferencias</a>
            <a href="/registro" class="navegacion__enlace <?php echo pagina_actual('/registro') ? 'navegacion__enlace--actual' : ''?>">Comprar pase</a>
        </nav>
    </div>
</div>