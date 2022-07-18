<div class="contenedor login">
   
<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar sesion</p>

        <?php include_once __DIR__.'/../templates/alertas.php';?>

        <form class="formulario" method="POST" action="/">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu email" value="<?php echo $usuario->email?>">
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Tu password">
            </div>

            <input class="boton" type="submit" value="Entrar">
        </form>
    
            <div class="acciones">
                <a href="/crear">No tienes una cuenta? Crea una</a>
                <a href="/olvide">Olvide mi password</a>
            </div>
    </div>
</div>


