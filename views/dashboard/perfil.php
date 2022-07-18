<?php include_once __DIR__.'/header-dashboard.php'; ?>

    <div class="contenedor-sm">
        <?php include_once __DIR__.'/../templates/alertas.php';?>

        <div class="cambiar-password">
            <a href="/cambiar-password" class="enlace-password">Cambiar mi Password</a>
        </div>

        <form class="formulario" method="POST">
            <?php include_once __DIR__.'/../templates/alertas.php';?>
            
            <div class="campo">
                <label for="nombre">Nombre</label> 
                <input type="nombre" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo $usuario->nombre?>">
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu email" value="<?php echo $usuario->email?>">
            </div>

            <input type="submit" value="Guardar cambios">
        </form>
    </div>



<?php include_once __DIR__.'/footer-dashboard.php'; ?>