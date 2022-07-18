<?php include_once __DIR__.'/header-dashboard.php'; ?>

    <div class="contenedor-sm">
        <div class="contenedor-nueva-tarea">
            <button type="submit" class="agregar-tarea" id="agregar-tarea">&#43; Agregar Tarea</button>
        </div>

        <div id="filtros" class="filtros">
            <div class="filtros-inputs">
                <div class="campo">
                    <label for="todas">Todas</label>
                    <input name="filtro" type="radio" id="todas" value="" checked>
                </div>
                <div class="campo">
                    <label for="completas">Completas</label>
                    <input name="filtro" type="radio" id="completas" value="1">
                </div>
                <div class="campo">
                    <label for="pendientes">Pendientes</label>
                    <input name="filtro" type="radio" id="pendientes" value="0">
                </div>
            </div>
        </div>

        <div class="tareasContenedor"></div>
    </div>


    <?php include_once __DIR__.'/footer-dashboard.php'; ?>

<?php $script .= ' <script src="/build/js/tareas.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
' ?>

