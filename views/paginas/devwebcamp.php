<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo;?></h2>
    <p class="devwebcamp__descripcion">Conoce la conferencia más importante de España</p>
    <div class="devwebcamp__grid">
        <div <?php aos_animacion();?> class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img loading="lazy" width="200" height="300" src="build/img/sobre_devwebcamp.jpg" alt="Imagen devwebcamp">
            </picture>
        </div>
        
        <div <?php aos_animacion();?> class="devwebcamp__contenido">
            <p class="devwebcamp__texto"> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim, doloribus molestiae error nostrum qui non omnis architecto excepturi aliquam ducimus exercitationem pariatur fuga et, ut alias, possimus porro minima maxime!</p>
            <p class="devwebcamp__texto"> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim, doloribus molestiae error nostrum qui non omnis architecto excepturi aliquam ducimus exercitationem pariatur fuga et, ut alias, possimus porro minima maxime!</p>
        </div>
    </div>
</main>