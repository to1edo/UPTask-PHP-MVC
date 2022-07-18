<div class="contenedor olvide">
   
<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Olvide mi password</p>

        <?php include_once __DIR__.'/../templates/alertas.php';?>
        
        <form class="formulario" method="POST" action="/olvide">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu email">
            </div>

            <input class="boton" type="submit" value="Enviar">
        </form>
    
            <div class="acciones">
                <a href="/crear">No tienes una cuenta? Crea una</a>
            </div>
    </div>
</div>


