<?php include_once __DIR__.'/header-dashboard.php'; ?>

    <div class="contenedor-sm">
        <div class="contenedor-nueva-tarea">
            <button type="submit" class="agregar-tarea" id="agregar-tarea">&#43; Agregar Tarea</button>
            <button type="submit" class="borrar-proyecto" id="borrar-proyecto">
                <svg xmlns="http://www.w3.org/2000/svg" id="proyecto-btn" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg> 
            Borrar Proyecto
            </button>
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

