<div class="contenedor restablecer">
   
<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Restablecer tu password</p>

        <?php if($confirmado){ ?>

            
            <?php include_once __DIR__.'/../templates/alertas.php';?>

            <form class="formulario" method="POST">
                <div class="campo">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Tu password">
                </div>

                <div class="campo">
                    <label for="password2">Confirmar password</label>
                    <input type="password" name="password2" id="password2" placeholder="Repite tu password">
                </div>

                <input class="boton" type="submit" value="Restablecer">
            </form>

        <?php } else { ?>

            <svg class="no-confirmado" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <p>Token no valido</p>

        <?php } ?>
    
        <div class="acciones">
            <a href="/crear">No tienes una cuenta? Crea una</a>
            
            <a href="/">Iniciar sesion</a>
        </div>
    </div>
</div>


