<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo;?></h2>

    <p class="registro__descripcion"> Elige tu plan</p>

    <div class="paquetes__grid">
        <div class="paquete">
            <h3 class="paquete__nombre">Pase gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso virtual a DevWebCamp</li>
            </ul>

            <p class="paquete__precio"> 0€</p>

            <form action="/finalizar-registro/gratis" method="POST">
                <input class="paquetes__submit" type="submit" value="Inscripción gratis">
            </form>
        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">Pase presencial</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso virtual a DevWebCamp</li>
                <li class="paquete__elemento">Acceso presencial a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 días</li>
                <li class="paquete__elemento">Acceso a Talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a las grabaciones</li>
                <li class="paquete__elemento">Camiseta del evento</li>
                <li class="paquete__elemento">Comida y Bebida</li>
            </ul>

            <p class="paquete__precio"> 70€</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>

        </div>
            
        <div class="paquete">
            <h3 class="paquete__nombre">Pase virtual</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso virtual a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 días</li>
                <li class="paquete__elemento">Enlace a Talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a las grabaciones</li>
            </ul>

            <p class="paquete__precio"> 35€</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>

        </div>

    </div>
</main>



<!-- Reemplazar CLIENT_ID por tu client id proporcionado al crear la app desde el developer dashboard) -->
<script src="https://www.paypal.com/sdk/js?client-id=ASI0Wt6OjIEWwePt5mhnUxVGRFCYCFL_v0cSQokP6LnJBkfvx3cOgoCZ6IrBas5cl9e0ohmmkP59sY-O&enable-funding=venmo&currency=EUR" data-sdk-integration-source="button-factory"></script>
 
<script>

   const urlConferencias=window.location.origin + '/finalizar-registro/conferencias';


    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },
 
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"1","amount":{"currency_code":"EUR","value":70}}]
          });
        },
 
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
            
            const datos= new FormData();
            datos.append('paquete_id',orderData.purchase_units[0].description);
            datos.append('pago_id',orderData.purchase_units[0].payments.captures[0].id);


            fetch('/finalizar-registro/pagar', {
                method: 'POST',
                body: datos
            }).then(respuesta => respuesta.json())
            .then(resultado => {
                
                if(resultado.resultado) {
                    actions.redirect(urlConferencias);
                }
            })
          });
        },
 
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
 
  initPayPalButton();
</script>