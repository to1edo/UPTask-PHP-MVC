<div class="contenedor crear">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
    
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crear tu cuenta</p>

        <?php include_once __DIR__.'/../templates/alertas.php';?>
        
        <form class="formulario" method="POST" action="/crear">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo $usuario->nombre; ?>">
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu email" value="<?php echo $usuario->email; ?>">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Tu password">
            </div>

            
            <div class="campo">
                <label for="password2">Confirmar password</label>
                <input type="password" name="password2" id="password2" placeholder="Repite tu password">
            </div>

            <input class="boton" type="submit" value="Crear cuenta">
        </form>
    
            <div class="acciones">
                <a href="/">Ya tienes una cuenta? Inicia sesion</a>
            </div>
    </div>
</div>


