<?php include_once __DIR__.'/header-dashboard.php'; ?>

    <div class="proyectos-container">

        <?php if(count($proyectos) === 0){?>

            <div class="vacio">
                <p>Aun no tienes proyectos para mostrar</p>
                <a  href="/crear-proyecto">Empieza creando uno</a>  
            </div>

        <?php }else{?>
        <?php foreach($proyectos as $proyecto):?>
            <a  href="/proyecto?id=<?php echo $proyecto->url;?>" class="proyecto">

                <p class="proyecto-nombre"><?php echo $proyecto->proyecto ;?></p>
                
            </a>
        <?php endforeach;?>
        <?php }?>
    </div>
    

<?php include_once __DIR__.'/footer-dashboard.php'; ?>