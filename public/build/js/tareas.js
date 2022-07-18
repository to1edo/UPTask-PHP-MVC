
//IIFE
(function(){

    let tareas = [];
    let tareasFiltradas = [];
    obtenerTareas();

    const nuevaTareaBtn = document.getElementById('agregar-tarea');
    nuevaTareaBtn.addEventListener('click', function(){
        mostrarFormulario();
    });

    function mostrarFormulario( editar = false , tarea = {}){
        
        const modal = document.createElement('DIV');
        modal.classList.add('modal');

        modal.innerHTML = `
            <form class="formulario nueva-tarea" method="POST">
                
                <legend> ${ editar ? 'Editar tarea' : 'Agrega una tarea'}</legend>

                <div class="campo">
                    <label for="tarea">Tarea</label>
                    <input type="text" class="titulo-tarea" id="tarea" name="tarea" placeholder="Titulo de la tarea"  value="${ editar ? tarea.nombre : ''}"></input>
                </div>

                <div class="opciones">
                    <input  type="submit" class="guardar-tarea" value="${ editar ? 'Editar tarea' : 'Agrega tarea'}" />
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
                
            </form>
        `;


        const divPrincipal = document.querySelector('.principal');
        divPrincipal.appendChild(modal);

        modal.addEventListener('click',function(e){
            e.preventDefault();
        });
        
        //cerrar modal
        const cerrar = document.querySelector('.cerrar-modal');
        cerrar.addEventListener('click', borrarModal);

         function borrarModal(){
            
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('cerrar');
            const modal = document.querySelector('.modal');

            setTimeout(() => {
                modal.remove();
            }, 500);
         }


         //agregar tarea

        const agregar = document.querySelector('.guardar-tarea');
        agregar.addEventListener('click', agregarTarea);

        function agregarTarea(){
            const nombreTarea = document.querySelector('#tarea').value.trim();
            
            if(nombreTarea === ''){
                //motrar alerta

                Swal.fire({
                    icon: 'error',
                    title: 'Error.',
                    text: 'Debes ingresar el nombre de la tarea!'
                }) 

                return;
            }

            if(editar){
                tarea.nombre = nombreTarea;
                actualizarTarea(tarea);
            }else{
                guardarTarea(nombreTarea);
            }

            borrarModal();
        }
    }

    //flitros para mostrar tareas
    const filtros = document.querySelectorAll('#filtros input[type="radio"]');
    filtros.forEach( radio => radio.addEventListener('click', filtrarTareas) );

    function filtrarTareas(e){
        const filtro = e.target.value;

        if(filtro !== ''){
            tareasFiltradas = tareas.filter(tarea => tarea.estado === filtro );
            mostrarTareas(tareasFiltradas);
        }else
        {   
            mostrarTareas(tareas);
        }
    }

    async function guardarTarea(nombreTarea){
        
        const datos = new FormData();
        datos.append('nombre',nombreTarea);
        datos.append('proyectoId',obtenerProyecto());

        try {
            const url = 'https://uptask-to1edo.herokuapp.com/api/tarea';

            const respuesta = await fetch(url,{
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            if(resultado.tipo === 'exito'){
                Swal.fire(
                    'Exito!',
                    'Tarea agregada correctamente',
                    'success'
                  )

            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Hubo un error al intentar guardar la tarea'
                }) 
            }

            // crear objeto de la tarea y agregarlo al global de tareas

            tareaObj= {
                estado: '0',
                id: String(resultado.id),
                nombre: nombreTarea,
                proyectoId: resultado.proyectoId,
            }

            tareas = [...tareas,tareaObj];
            mostrarTareas(tareas);

        } catch (error) {
            console.log(error);          
        }

    }

    function obtenerProyecto(){
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }

    async function obtenerTareas(){
        try {
            const url = `https://uptask-to1edo.herokuapp.com/api/tarea?id=${obtenerProyecto()}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            tareas = resultado.tareas;
            mostrarTareas(tareas);
        } catch (error) {
            console.log(error);
        }
    }


    function mostrarTareas(tareas){
        const tareasContenedor = document.querySelector('.tareasContenedor');

        tareasContenedor.textContent = ''; //limpiar html de tareas previas

        const titulo = document.createElement('H3');
        titulo.classList.add('titulo');
        titulo.textContent = 'Lista de tareas';
        tareasContenedor.appendChild(titulo);

        if(tareas.length > 0){

            const estados = {
                0: 'Pendiente',
                1: 'Completa'
            };

            tareas.forEach(element => {
                
                const tarea = document.createElement('DIV');
                tarea.classList.add('tarea');
    
                const nombre =document.createElement('P');
                nombre.classList.add('nombre');
                nombre.textContent = element.nombre;

                nombre.onclick = function(){
                    mostrarFormulario(true , {...element});
                };
                
                const opciones = document.createElement('DIV');
                opciones.classList.add('opciones');

                const btnBorrar = document.createElement('BUTTON');
                btnBorrar.classList.add('boton-borrar');
                btnBorrar.setAttribute('title', 'Borrar tarea');
                btnBorrar.dataset.tareaId = element.id;
                btnBorrar.textContent = 'Eliminar';

                btnBorrar.onclick =function(){
                    confirmarBorrar({...element});
                };

                const btnEstado = document.createElement('BUTTON');
                btnEstado.classList.add('boton-estado');
                btnEstado.classList.add(`${estados[element.estado].toLowerCase()}`);
                btnEstado.dataset.estadoTarea = element.estado;
                btnEstado.textContent = estados[element.estado];
                btnEstado.setAttribute('title', 'Cambiar estado de la tarea');

                btnEstado.onclick = function(){
                    cambiarEstadoTarea({...element});
                };
                
                opciones.appendChild(btnEstado);
                opciones.appendChild(btnBorrar);
                
                tarea.appendChild(nombre);
                tarea.appendChild(opciones);
                
                tareasContenedor.appendChild(tarea);
            });
        }
        else{
            const mensaje = document.createElement('P');
            mensaje.classList.add('mensaje');
            mensaje.textContent = 'No tienes tareas por ahora';
            tareasContenedor.appendChild(mensaje);
        }
    }


    function cambiarEstadoTarea(tarea){

        const nuevoEstado = tarea.estado === '1' ? '0' : '1';
        tarea.estado = nuevoEstado;

        actualizarTarea(tarea);
    }

    function confirmarBorrar(tarea){
        Swal.fire({
            title: 'Deseas eliminar la tarea?',
            text: "No podrás recuperarla después de eliminada!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {  
                borrarTarea(tarea);
            }
          })
    }

    async function borrarTarea(tarea){

        const datos = new FormData();
        datos.append('tareaId',tarea.id);
        datos.append('proyectoId',tarea.proyectoId);

        try {
            const url = 'https://uptask-to1edo.herokuapp.com/api/tarea/eliminar';
            const respuesta = await fetch(url,{
                method: 'POST',
                body: datos
            })

            const resultado = await respuesta.json();

            Swal.fire({
                position: 'top-end',
                icon: resultado.tipo,
                title: resultado.mensaje,
                showConfirmButton: false,
                timer: 1000
              })
              
            tareas = tareas.filter( tareaMemoria => tareaMemoria.id !== tarea.id);

            mostrarTareas(tareas);

        } catch (error) {
            console.log(error);
        }

    }

    async function actualizarTarea(tarea){

        const datos = new FormData();
        datos.append('tareaId',tarea.id);
        datos.append('nombre',tarea.nombre);
        datos.append('estado',tarea.estado);
        datos.append('proyectoId',tarea.proyectoId);

        try {
            const url = 'https://uptask-to1edo.herokuapp.com/api/tarea/actualizar';
            const respuesta = await fetch(url,{
                method: 'POST',
                body: datos
            })

            const resultado = await respuesta.json();

            Swal.fire({
                position: 'top-end',
                icon: resultado.tipo,
                title: resultado.mensaje,
                showConfirmButton: false,
                timer: 1000
              })

            tareas = tareas.map( tareaMemoria =>{

                if(tareaMemoria.id === tarea.id){
                    tareaMemoria.estado = tarea.estado;
                    tareaMemoria.nombre = tarea.nombre;
                }

                return tareaMemoria;
            });

            mostrarTareas(tareas);

        } catch (error) {
            console.log(error);
        }
    }


    const proyectoBtn = document.querySelector(".borrar-proyecto");
    proyectoBtn.addEventListener("click",function(){
        Swal.fire({
            title: 'Deseas eliminar este proyecto?',
            text: "No podrás recuperarlo después de eliminado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {  
                borrarProyecto();
            }
          })
    });

    async function borrarProyecto(){

        proyecto = obtenerProyecto();
        
        const datos = new FormData();
        datos.append('proyectoUrl',proyecto);

        try {
            const url = 'https://uptask-to1edo.herokuapp.com/proyecto/eliminar';
            const respuesta = await fetch(url,{
                method: 'POST',
                body: datos
            })

            const resultado = await respuesta.json();

            Swal.fire({
                position: 'top-end',
                icon: resultado.tipo,
                title: resultado.mensaje,
                showConfirmButton: false,
                timer: 1000
              })
            

        } catch (error) {
            console.log(error);
        }

    } 

})();