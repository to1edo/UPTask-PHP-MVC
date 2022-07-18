<?php include_once __DIR__.'/header-dashboard.php'; ?>

    <div class="contenedor-sm">
        <?php include_once __DIR__.'/../templates/alertas.php';?>

        <div class="cambiar-password">
            <a href="/perfil" class="enlace-password">Volver al perfil</a>
        </div>

        <form class="formulario" method="POST">
            <?php include_once __DIR__.'/../templates/alertas.php';?>
            
            <div class="campo">
                <label for="password">Password Actual</label>
                <input type="password" name="passwordActual" id="password" placeholder="Tu password">
            </div>
            <div class="campo">
                <label for="passwordNueva">Password Nueva</label>
                <input type="password" name="passwordNueva" id="passwordNueva" placeholder="Password nueva">
            </div>
            <div class="campo">
                <label for="passwordConfirmar">Confirmar Password</label>
                <input type="password" name="passwordConfirmar" id="passwordConfirmar" placeholder="Confirmar password nueva">
            </div>

            <input type="submit" value="Cambiar Password">
        </form>
    </div>



<?php include_once __DIR__.'/footer-dashboard.php'; ?>